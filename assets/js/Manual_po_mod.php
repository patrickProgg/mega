<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manual_po_mod extends CI_Model
{



    function __construct()
    {
        parent::__construct();

        $this->ord = $this->load->database('ordering', TRUE);
        // $this->ord = $this->load->database('manualPo', TRUE);
        $db_name = get_db_connection_name();
        $this->load->database($db_name);

        $this->load->model('Acct_mod');

        $this->store_details = array(
            array("store_id" => 1, "bu" => "ISLAND CITY MALL", "dept" => "SUPERMARKET", "DR_format" => "SPOICM", "SI_format" => "SPOICMSM", "header_name" => "ALTURAS SUPERMARKET CORPORATION", "address" => "Dampas District, Tagbilaran City", "tel" => "038 501 3000 local 3103, 3500", "tin" => "000 254 327 00003"),
            array("store_id" => 2, "bu" => "ASC: MAIN", "dept" => "SUPERMARKET", "DR_format" => "SPOASC", "SI_format" => "SPOAMSM", "header_name" => "ALTURAS SUPERMARKET CORPORATION", "address" => "B. Inting Street, Tagbilaran City", "tel" => "038 501 3000 local 3207", "tin" => "000 254 327 00000"),
            array("store_id" => 3, "bu" => "PLAZA MARCELA", "dept" => "SUPERMARKET", "DR_format" => "SPOPM", "SI_format" => "", "header_name" => "MARCELA FARMS INCORPORATED", "address" => "Cogon, Tagbilaran City", "tel" => "038 501 3000 local 3310", "tin" => "004 283 221 002"),
            array("store_id" => 4, "bu" => "ALTURAS TALIBON", "dept" => "SUPERMARKET", "DR_format" => "SPOTAL", "SI_format" => "SPOATLSM", "header_name" => "ALTURAS SUPERMARKET CORPORATION", "address" => "Poblacion, Talibon, Bohol", "tel" => "038 515 5107", "tin" => "000 254 327 00002"),
            array("store_id" => 5, "bu" => "ALTA CITTA", "dept" => "SUPERMARKET", "DR_format" => "", "SI_format" => "", "header_name" => "ALTURAS SUPERMARKET CORPORATION", "address" => "H. Grupo Street, Tagbilaran Bohol", "tel" => "038 501 3000 local 3250", "tin" => "000 254 327 00009"),
            array("store_id" => 6, "bu" => "CENTRAL DISTRIBUTION CENTER", "dept" => "WAREHOUSE", "DR_format" => "SMG-CPO", "SI_format" => "ASMGM-RPO", "header_name" => "ALTURAS SUPERMARKET CORPORATION", "address" => "Upper De La Pas, Cortes, Bohol", "tel" => "038 501 3000 local 4307", "tin" => "000 254 327 00007"),
            array("store_id" => 32, "bu" => "COLONADE COLON", "dept" => "SUPERMARKET", "DR_format" => "", "SI_format" => "CSM", "header_name" => "CEBO DEVELOPMENT CORPORATION", "address" => "Colon Street, Cebu City", "tel" => "038 501 3000 local 94800", "tin" => "200 017 869 000"),
            array("store_id" => 31, "bu" => "ALTURAS PANGLAO", "dept" => "SUPERMARKET", "DR_format" => "SPOTAL", "SI_format" => "SPOATLSM", "header_name" => "ALTURAS SUPERMARKET CORPORATION", "address" => "Bolod, Panglao, Bohol", "tel" => "038 501 3000 local 97100", "tin" => "000 254 327 00010"),
        );
    }

    public function get_store_details_by_id($store_id)
    {
        $store_arr = [];
        foreach ($this->store_details as $sd) {
            if ($store_id == $sd["store_id"]) {
                $store_arr = $sd;
                break;
            }
        }

        return $store_arr;
    }

    public function get_store_id($bu, $dept)
    {
        $store_id = 0;
        foreach ($this->store_details as $sd) {
            if ($bu == $sd["bu"] && $dept == $sd["dept"]) {
                $store_id = $sd["store_id"];
                break;
            }
        }

        return $store_id;
    }

    public function get_source_data($source_table, $po_calendar)
    {
        if (!$this->ord->table_exists($source_table)) {
            log_message('error', "Source table '{$source_table}' does not exist in the 'ordering' database."); // uncomment after finalize
            return [];
        }

        // Fetch all vendor mappings from po_calendar dynamically
        // $po_calendar_data = $this->db->select('no_, vend_type, name_')
        //     ->get($po_calendar)
        //     ->result_array();

        $po_calendar_data = $this->db->select('po_calendar.no_, po_calendar.name_, po_calendar.vend_type, po_date.po_id, po_date.group_code')
            ->from('po_calendar')
            ->join('po_date', 'po_calendar.po_id = po_date.po_id', 'left')
            // ->group_by('po_date.po_id')
            ->get()
            ->result_array();




        // var_dump($po_calendar_data);
        // exit;
        // Create a vendor code to vend_type map
        $vendor_data_map = [];
        foreach ($po_calendar_data as $row) {
            $vendor_data_map[$row['no_']] = [
                'vend_type' => $row['vend_type'],
                'name_' => $row['name_'],
                'group_code' => $row['group_code']
            ];
        }

        // Fetch data from the source table in the 'ordering' database
        $this->ord->where("{$source_table}.status", 0); // uncomment after finalize
        $query = $this->ord->get($source_table); // uncomment after finalize

        if ($query->num_rows() > 0) {
            $result = $query->result_array();


            foreach ($result as &$row) {
                $row['vend_type'] = isset($vendor_data_map[$row['vendor_code']]) ? $vendor_data_map[$row['vendor_code']]['vend_type'] : "";  // "DR"; "NO SETUP";
                $row['vendor_name'] = isset($vendor_data_map[$row['vendor_code']]) ? $vendor_data_map[$row['vendor_code']]['name_'] : "";
                $row['mp_group_code'] = isset($vendor_data_map[$row['vendor_code']]) ? $vendor_data_map[$row['vendor_code']]['group_code'] : "";
            }

            $grouped_data = [];

            foreach ($result as $row) {
                $key = $this->get_grouping_key($source_table, $row);
                if (!isset($grouped_data[$key])) {
                    $grouped_data[$key] = $row;
                    $grouped_data[$key]['qty'] = 0;
                }
                $grouped_data[$key]['qty'] += $row['qty'];
            }

            return array_values($grouped_data);
        }

        log_message('info', "No data found in the source table '{$source_table}'.");
        return [];
    }

    // private function get_grouping_key($source_table, $row)
    // {
    //     if ($source_table === 'mp_tbl_app_countdatas') {
    //         return "{$row['itemcode']}-{$row['uom']}-{$row['description']}-{$row['business_unit']}-{$row['variant_code']}";
    //     } elseif ($source_table === 'mp_tbl_app_nfitems') {
    //         return "{$row['itemcode']}-{$row['uom']}-{$row['inputted_desc']}-{$row['business_unit']}-{$row['variant_code']}";
    //     }
    //     return '';
    // }

    private function get_grouping_key($source_table, $row)
    {
        if ($source_table === 'tbl_app_countdata') {
            return "{$row['itemcode']}-{$row['uom']}-{$row['desc']}-{$row['business_unit']}-{$row['variant_code']}";
        } elseif ($source_table === 'tbl_app_nfitem') {
            return "{$row['itemcode']}-{$row['uom']}-{$row['inputted_desc']}-{$row['business_unit']}";
        }
        return '';
    }


    public function insert_into_header($data)
    {
        $header_table = 'manual_po_header';  // Define the header table name

        // $this->db->select('mp_hd_id');
        // $this->db->where('vendor_code', $data['vendor_code']);
        // // $this->db->where('reorder_date', $data['reorder_date']);
        // $this->db->where('DATE(reorder_date)', date('Y-m-d', strtotime($data['reorder_date'])));
        // $this->db->where('bu', $data['bu']);
        // $query = $this->db->get($header_table);

        // // If the record already exists, skip the insert
        // if ($query->num_rows() > 0) {
        //     log_message('info', "Record already exists in '{$header_table}' for vendor: {$data['vendor_code']}, reorder_date: {$data['reorder_date']}, business_unit: {$data['bu']}");

        //     return $query->row_array()["mp_hd_id"]; // Indicating no insert was performed
        // }

        if ($this->db->insert($header_table, $data)) {
            // Return the inserted row's ID (auto-increment ID)
            return $this->db->insert_id();
        }

        // Log the error if insertion fails
        $error = $this->db->error();
        log_message('error', "Failed to insert into '{$header_table}'. Error: " . $error['message'] . ". Data: " . json_encode($data));
        return false;
    }

    // Insert data into the 'manual_po_lines' table
    public function insert_into_lines($data)
    {
        $lines_table = 'manual_po_lines';  // Define the lines table name

        if ($this->db->insert($lines_table, $data)) {
            return true;
        }

        $error = $this->db->error();
        log_message('error', "Failed to insert into '{$lines_table}'. Error: " . $error['message'] . ". Data: " . json_encode($data));
        return false;
    }

    public function update_status($table_name, $new_status)
    {
        $this->ord->set('status', $new_status); // uncomment after finalize
        $this->ord->where('status', 0);  // Ensure only rows with status 0 are updated // uncomment after finalize
        $this->ord->update($table_name); // uncomment after finalize

        // $this->db->set('status', $new_status);
        // $this->db->where('status', 0);  // Ensure only rows with status 0 are updated
        // $this->db->update($table_name);
    }

    public function getStoreName($user_store_id)
    {
        $this->db->select('display_name');
        $this->db->from('reorder_store');
        $this->db->where('reorder_store.store_id', $user_store_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getPoData($start = 0, $length = 10, $column_index = 0, $sort_direction = 'asc', $search, $status = null, $store_id, $type, $link, $user_type)
    {
        if ($store_id == 6 && $user_type == 'buyer') {

            if ($link == 'cdc') { // CDC's Own Reorders

                $columns = ['mp_hd_id', 'vendor_code', 'vendor_name', 'date_generated', 'status'];
                $sort_column = $columns[$column_index];

                // Base query
                $this->db->select('mp_hd_id, vendor_code, vendor_name, date_generated, status, bu, value_, dept, manual_po_header.store_id, vend_type, user_id');
                $this->db->from('manual_po_header');
                $this->db->join('reorder_store', 'manual_po_header.store_id = reorder_store.store_id', 'inner');
                $this->db->order_by('manual_po_header.mp_hd_id', 'DESC');


                // Search condition (if any)
                if (!empty($search)) {
                    $numericSearch = preg_replace('/\D/', '', $search); // Removes non-numeric characters
                    $dateFormatted = date('Y-m-d', strtotime($search));

                    // Group search conditions to avoid conflict with status filtering
                    $this->db->group_start();
                    $this->db->like('mp_hd_id', $numericSearch); // Search as an integer
                    // $this->db->like('mp_hd_id', $search);
                    $this->db->or_like('vendor_code', $search);
                    $this->db->or_like('vendor_name', $search);
                    $this->db->or_like('date_generated', $dateFormatted);
                    // $this->db->or_like('date_generated', $search);
                    $this->db->or_like('status', $search);
                    $this->db->group_end();
                }

                // Handle the status filtering logic
                if (!empty($status)) {
                    // If status is an array (multiple statuses for 'pending')
                    if (is_array($status)) {
                        $this->db->where_in('status', $status);  // Use where_in for multiple statuses
                    } else {
                        $this->db->where('status', $status);  // Single status filter
                    }
                }

                $this->db->where('manual_po_header.store_id', $store_id);
                $this->db->where('vend_type', $type);
                // Count filtered results
                $filtered_records = $this->db->count_all_results('', false);

                // Apply sorting and limit
                $this->db->order_by($sort_column, $sort_direction);
                $this->db->limit($length, $start);

                // Execute the query
                $query = $this->db->get();
                $data = $query->result_array();

                return [
                    'total_records' => $this->db->count_all('manual_po_header'),
                    'filtered_records' => $filtered_records,
                    'data' => $data
                ];
            } else if ($link == 'store') {
                // var_dump($status);
                $columns = ['mp_hd_id', 'vendor_code', 'vendor_name', 'date_generated', 'status'];
                $sort_column = $columns[$column_index];

                // Base query
                $this->db->select('
                manual_po_header.mp_hd_id, 
                manual_po_header.vendor_code, 
                manual_po_header.vendor_name, 
                manual_po_header.date_generated, 
                manual_po_header.status, 
                manual_po_header.bu, 
                reorder_store.value_, 
                manual_po_header.dept, 
                manual_po_header.mp_group_code, 
                manual_po_header.store_id, 
                manual_po_header.vend_type, 
                reorder_users.user_id, 
                reorder_users.group_code
                ');
                $this->db->from('manual_po_header');
                $this->db->join('reorder_store', 'manual_po_header.store_id = reorder_store.store_id', 'inner');
                $this->db->join('reorder_users', 'manual_po_header.mp_group_code = reorder_users.group_code', 'inner');
                $this->db->order_by('manual_po_header.mp_hd_id', 'DESC');
                $this->db->group_by('manual_po_header.mp_hd_id');


                // Search condition (if any)
                if (!empty($search)) {
                    $numericSearch = preg_replace('/\D/', '', $search); // Removes non-numeric characters
                    $dateFormatted = date('Y-m-d', strtotime($search));

                    // Group search conditions to avoid conflict with status filtering
                    $this->db->group_start();
                    $this->db->like('mp_hd_id', $numericSearch); // Search as an integer
                    // $this->db->like('mp_hd_id', $search);
                    $this->db->or_like('vendor_code', $search);
                    $this->db->or_like('vendor_name', $search);
                    $this->db->or_like('date_generated', $dateFormatted);
                    // $this->db->or_like('date_generated', $search);
                    $this->db->or_like('status', $search);
                    $this->db->group_end();
                }

                // Handle the status filtering logic
                if (!empty($status)) {
                    // If status is an array (multiple statuses for 'pending')
                    if (is_array($status)) {
                        $this->db->where_in('status', $status);  // Use where_in for multiple statuses
                    } else {
                        $this->db->where('status', $status);  // Single status filter
                    }
                }

                // $this->db->where('manual_po_header.store_id', $store_id);
                $this->db->where('reorder_users.store_id', $store_id);
                // $this->db->where('reorder_users.group_code = manual_po_header.mp_group_code');
                $this->db->where('vend_type', $type);
                // Count filtered results
                $filtered_records = $this->db->count_all_results('', false);

                // Apply sorting and limit
                $this->db->order_by($sort_column, $sort_direction);
                $this->db->limit($length, $start);

                // Execute the query
                $query = $this->db->get();
                $data = $query->result_array();

                return [
                    'total_records' => $this->db->count_all('manual_po_header'),
                    'filtered_records' => $filtered_records,
                    'data' => $data
                ];
            }
        } else {
            $columns = ['mp_hd_id', 'vendor_code', 'vendor_name', 'date_generated', 'status'];
            $sort_column = $columns[$column_index];

            // Base query
            $this->db->select('mp_hd_id, vendor_code, vendor_name, date_generated, status, bu, value_, dept, manual_po_header.store_id, vend_type, user_id');
            $this->db->from('manual_po_header');
            $this->db->join('reorder_store', 'manual_po_header.store_id = reorder_store.store_id', 'inner');
            $this->db->order_by('manual_po_header.mp_hd_id', 'DESC');

            // Search condition (if any)
            if (!empty($search)) {
                $numericSearch = preg_replace('/\D/', '', $search); // Removes non-numeric characters
                $dateFormatted = date('Y-m-d', strtotime($search));

                // Group search conditions to avoid conflict with status filtering
                $this->db->group_start();
                $this->db->like('mp_hd_id', $numericSearch); // Search as an integer
                // $this->db->like('mp_hd_id', $search);
                $this->db->or_like('vendor_code', $search);
                $this->db->or_like('vendor_name', $search);
                $this->db->or_like('date_generated', $dateFormatted);
                // $this->db->or_like('date_generated', $search);
                $this->db->or_like('status', $search);
                $this->db->group_end();
            }

            // Handle the status filtering logic
            if (!empty($status)) {
                // If status is an array (multiple statuses for 'pending')
                if (is_array($status)) {
                    $this->db->where_in('status', $status);  // Use where_in for multiple statuses
                } else {
                    $this->db->where('status', $status);  // Single status filter
                }
            }

            $this->db->where('manual_po_header.store_id', $store_id);
            $this->db->where('vend_type', $type);
            // Count filtered results
            $filtered_records = $this->db->count_all_results('', false);

            // Apply sorting and limit
            $this->db->order_by($sort_column, $sort_direction);
            $this->db->limit($length, $start);

            // Execute the query
            $query = $this->db->get();
            $data = $query->result_array();

            return [
                'total_records' => $this->db->count_all('manual_po_header'),
                'filtered_records' => $filtered_records,
                'data' => $data
            ];
        }
    }

    public function getPoDetailsById($id, $start, $length, $order = [], $search)
    {
        $this->db->select('manual_po_header.*, manual_po_lines.*, reorder_store.value_, 
        GROUP_CONCAT(manual_po_line_history.mp_hist_id ORDER BY manual_po_line_history.mp_hist_id DESC SEPARATOR "|") AS hist_id_concat
        ,GROUP_CONCAT(manual_po_line_history.status ORDER BY manual_po_line_history.mp_hist_id DESC SEPARATOR "|") AS line_status')
            ->from('manual_po_header')
            ->join('manual_po_lines', 'manual_po_header.mp_hd_id = manual_po_lines.mp_hd_id', 'inner')
            ->join('reorder_store', 'manual_po_header.store_id = reorder_store.store_id', 'inner')
            ->join('manual_po_line_history', 'manual_po_lines.mp_ln_id = manual_po_line_history.mp_ln_id', 'left')
            ->where('manual_po_header.mp_hd_id', $id)

            // ->order_by('manual_po_line_history.status', 'DESC')
            // ->order_by("CASE 
            //     WHEN manual_po_line_history.status = 'Pending' THEN 1
            //     WHEN manual_po_line_history.status = 'Approved' THEN 2
            //     WHEN manual_po_line_history.status = 'Disapproved' THEN 3
            //     ELSE 4 
            // END", 'ASC')
            ->order_by('manual_po_lines.setup_status', 'DESC')
            ->order_by('manual_po_lines.mp_ln_id', 'ASC')
            // ->order_by('manual_po_lines.setup_status', 'DESC')
            ->order_by('manual_po_lines.data_status', 'DESC');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('item_code', $search);
            $this->db->or_like('item_desc', $search);
            $this->db->or_like('uom', $search);
            $this->db->or_like('qty_onhand', $search);
            $this->db->or_like('reorder_qty', $search);
            $this->db->or_like('reorder_qty_SI', $search);
            $this->db->group_end();
        }

        // Apply ordering if specified
        if (!empty($order)) {
            $columns = ['manual_po_lines.item_code', 'manual_po_lines.item_desc', 'manual_po_lines.uom', 'manual_po_lines.variant', 'manual_po_lines.qty_onhand', 'manual_po_lines.reorder_qty', 'manual_po_lines.reorder_qty_SI', 'manual_po_lines.item_desc'];
            $column_index = $order[0]['column'];
            $direction = $order[0]['dir'];
            if (isset($columns[$column_index])) {
                $this->db->order_by($columns[$column_index], $direction);
            }
        }

        // $filtered_records = $this->db->count_all_results('', false);


        $this->db->group_by("manual_po_lines.mp_ln_id");
        // $this->db->group_by(['manual_po_lines.item_code', 'manual_po_lines.uom']);
        // $this->db->limit($length, $start);

        $query = $this->db->get();
        return $query->result_array();

        // return [
        //     // 'filtered_records' => $filtered_records,
        //     'data' => $data
        // ];
    }

    public function countAllPoRecords($id)
    {
        $this->db->from('manual_po_header')
            ->join('manual_po_lines', 'manual_po_header.mp_hd_id = manual_po_lines.mp_hd_id', 'inner')
            ->where('manual_po_header.mp_hd_id', $id);
        // ->group_by('manual_po_lines.mp_ln_id');

        return $this->db->count_all_results();
    }

    public function get_all_reasons()
    {
        $query = $this->db->get('manual_po_reasons'); // Query the table
        return $query->result_array(); // Return as an array
    }

    public function get_current_reorder_qty_SI($mp_ln_id)
    {
        $this->db->select('reorder_qty_SI');
        $this->db->from('manual_po_lines');
        $this->db->where('mp_ln_id', $mp_ln_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result->reorder_qty_SI : null;
    }

    public function get_current_reorder_qty_DR($mp_ln_id)
    {
        $this->db->select('reorder_qty');
        $this->db->from('manual_po_lines');
        $this->db->where('mp_ln_id', $mp_ln_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result->reorder_qty : null;
    }

    public function insert_po_line_history($historyData)
    {
        $this->db->insert('manual_po_line_history', $historyData);
    }

    public function update_reorder_qty_SI($mp_ln_id, $nextQtySI)
    {
        $this->db->where('mp_ln_id', $mp_ln_id);
        $this->db->update('manual_po_lines', ['reorder_qty_SI' => $nextQtySI]);
    }

    public function update_reorder_qty_DR($mp_ln_id, $nextQtyDR)
    {
        $this->db->where('mp_ln_id', $mp_ln_id);
        $this->db->update('manual_po_lines', ['reorder_qty' => $nextQtyDR]);
    }

    public function getMpLineDetails($mp_ln_id, $start, $length, $search, $order)
    {
        // $this->db->select('manual_po_lines.item_desc, manual_po_line_history.*, manual_po_line_history.status AS line_status');
        // $this->db->join('manual_po_lines', 'manual_po_line_history.mp_ln_id = manual_po_lines.mp_ln_id', 'inner');
        // $this->db->from('manual_po_line_history');
        // $this->db->where('mp_ln_id', $mp_ln_id);
        // $this->db->order_by('date_adjusted');

        $this->db->select('manual_po_lines.item_desc, manual_po_header.vend_type, manual_po_line_history.*, manual_po_line_history.status AS line_status');
        $this->db->from('manual_po_line_history');
        $this->db->join('manual_po_lines', 'manual_po_line_history.mp_ln_id = manual_po_lines.mp_ln_id', 'inner');
        $this->db->join('manual_po_header', 'manual_po_lines.mp_hd_id = manual_po_header.mp_hd_id', 'inner');
        $this->db->where('manual_po_line_history.mp_ln_id', $mp_ln_id);
        $this->db->order_by('manual_po_line_history.date_adjusted');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('user_id', $search);
            $this->db->or_like('date_adjusted', $search);
            $this->db->or_like('prev_rqty', $search);
            $this->db->or_like('next_rqty', $search);
            $this->db->or_like('prev_rqty_SI', $search);
            $this->db->or_like('next_rqty_SI', $search);
            $this->db->or_like('line_status', $search);
            $this->db->or_like('status_by', $search);
            $this->db->group_end();
        }

        if (!empty($order)) {
            $column_index = $order[0]['column'];
            $column_name = $this->getColumnName($column_index);
            $dir = $order[0]['dir'];
            $this->db->order_by($column_name, $dir);
        }

        $this->db->limit($length, $start);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            // Process each result to display all reasons
            foreach ($result as &$row) {

                $user_details = $this->Acct_mod->getUserDetailsById($row["user_id"]);
                $emp_id = (isset($user_details)) ? $user_details["emp_id"] : "";
                $emp_details = $this->Acct_mod->retrieveEmployeeName($emp_id);
                $emp_name = (isset($emp_details)) ? $emp_details["name"] : "";
                $row["emp_name"] = $emp_name;


                // Get emp_name based on status_by (assuming it stores user_id)
                $status_by_details = $this->Acct_mod->getUserDetailsById($row["status_by"]);
                $status_by_emp_id = (isset($status_by_details)) ? $status_by_details["emp_id"] : "";
                $status_by_emp_details = $this->Acct_mod->retrieveEmployeeName($status_by_emp_id);
                $status_by_emp_name = (isset($status_by_emp_details)) ? $status_by_emp_details["name"] : "";
                $row["status_by_emp_name"] = $status_by_emp_name;

                // Split the reason_id string into an array
                $reason_ids = explode(',', $row['reason_id']);
                $reasons = [];

                // Fetch the corresponding reasons, ensuring no duplicates
                foreach ($reason_ids as $reason_id) {
                    // Only fetch if the reason_id is not already in the list
                    if (!in_array($reason_id, $reasons)) {
                        $this->db->select('reason');
                        $this->db->from('manual_po_reasons');
                        $this->db->where('reason_id', $reason_id);
                        $query_reason = $this->db->get();

                        if ($query_reason->num_rows() > 0) {
                            $reasons[] = $query_reason->row()->reason; // Add the reason to the list
                        }
                    }
                }

                // Join all the reasons into a single string (if needed)
                $row['reason'] = implode(', ', $reasons);
            }

            // Return the data
            echo json_encode([
                'draw' => $this->input->post('draw'),
                'recordsTotal' => $query->num_rows(),
                'recordsFiltered' => $query->num_rows(),
                'data' => $result
            ]);
            exit();
        }
    }

    private function getColumnName($index)
    {
        // Mapping DataTable column indexes to the database column names
        $columns = [
            'user_id',
            'date_adjusted',
            'prev_rqty',
            'next_rqty',
            'prev_rqty_SI',
            'next_rqty_SI',
            'reason',
            'line_status',
            'status_by'
        ];
        return isset($columns[$index]) ? $columns[$index] : 'user_id'; // Default to 'user_id' if invalid index
    }

    public function update_po_line_history($mp_ln_id, $user_id)
    {
        $this->db->where('mp_ln_id', $mp_ln_id);
        $this->db->update('manual_po_line_history', ['status_by' => $user_id]);
        // $this->db->update('manual_po_line_history', ['status' => "approved"]);
    }

    public function getLnData($mp_ln_id)
    {
        $this->db->select('mp_ln_id, item_code, item_desc,variant, uom, prev_desc');
        $this->db->from('manual_po_lines');
        $this->db->where('mp_ln_id', $mp_ln_id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function saveItem($data)
    {
        $this->db->where('mp_ln_id', $data['mp_ln_id']);
        $query = $this->db->get('manual_po_lines');

        if ($query->num_rows() > 0) {
            return $this->db->where('mp_ln_id', $data['mp_ln_id'])->update('manual_po_lines', $data);
        } else {
            return false; // Do nothing if the record does not exist
        }
    }

    private function setUpNavConnect($db_id)
    {
        $cmd = "SELECT * FROM `database` WHERE db_id=?";
        $query = $this->db->query($cmd, array($db_id));
        return $query->row_array();
    }

    function getItemDescFromNav($item_code)
    { // Navision

        $nav_data = $this->setUpNavConnect(5);

        $table = '[' . $nav_data['sub_db_name'] . '$Item]';
        // $connect = odbc_connect($nav_data['db_name'], $nav_data['username'], $nav_data['password']);
        $connect = odbc_connect("Driver={SQL Server};Server=" . $nav_data["server_address"] . ";Database=" . $nav_data["sql_dbname"] . ";", $nav_data["username"], $nav_data["password"]);

        $table_query = "SELECT [Extended Description] AS item_desc 
                       FROM " . $table . " WHERE [No_]=?";

        $result = odbc_prepare($connect, $table_query);
        odbc_execute($result, array($item_code));

        $description = "";

        if ($row = odbc_fetch_array($result)) {
            $description = $row["item_desc"];
        }

        odbc_free_result($result);
        odbc_close($connect);
        return $description;
    }

    function getUomsFromNav($item_code)
    { // Navision

        $nav_data = $this->setUpNavConnect(5);

        $table = '[' . $nav_data['sub_db_name'] . '$Item Unit of Measure]';
        // $connect = odbc_connect($nav_data['db_name'], $nav_data['username'], $nav_data['password']);
        $connect = odbc_connect("Driver={SQL Server};Server=" . $nav_data["server_address"] . ";Database=" . $nav_data["sql_dbname"] . ";", $nav_data["username"], $nav_data["password"]);

        $table_query = "SELECT REPLACE([Code],'''','') AS uom, [Qty_ per Unit of Measure] AS qty_uom 
                       FROM " . $table . " WHERE [Item No_]=?";

        $result = odbc_prepare($connect, $table_query);
        odbc_execute($result, array($item_code));

        $uoms = array();

        while ($row = odbc_fetch_array($result)) {
            //  $uom["uom"] = $row["uom"];
            //  $uom["qty_uom"] = round($row["qty_uom"],10);
            //  $uoms[] = $uom;
            $uoms[] = $row["uom"];
        }

        odbc_free_result($result);
        odbc_close($connect);
        return $uoms;
    }

    function getVariantsFromNav($item_code)
    { // Navision

        $nav_data = $this->setUpNavConnect(5);

        $table = '[' . $nav_data['sub_db_name'] . '$Item Variant]';
        // $connect = odbc_connect($nav_data['db_name'], $nav_data['username'], $nav_data['password']);
        $connect = odbc_connect("Driver={SQL Server};Server=" . $nav_data["server_address"] . ";Database=" . $nav_data["sql_dbname"] . ";", $nav_data["username"], $nav_data["password"]);

        // $table_query = "SELECT [Code] AS variant FROM " . $table . " WHERE [Item No_]=?";
        $table_query = "SELECT COALESCE([Description 2], '') + ' ' + COALESCE([Description], '') AS variant FROM " . $table . " WHERE [Item No_]=?";

        $result = odbc_prepare($connect, $table_query);
        odbc_execute($result, array($item_code));

        $variants = array();

        while ($row = odbc_fetch_array($result)) {
            $variants[] = $row["variant"];
        }

        odbc_free_result($result);
        odbc_close($connect);
        return $variants;
    }

    // function getItemCode($description)
    // {
    //     $nav_data = $this->setUpNavConnect(5);

    //     $table = '[' . $nav_data['sub_db_name'] . '$Item]';

    //     $connect = @odbc_connect(  // Suppress connection warnings with '@'
    //         "Driver={SQL Server};Server=" . $nav_data["server_address"] . ";Database=" . $nav_data["sql_dbname"] . ";",
    //         $nav_data["username"],
    //         $nav_data["password"]
    //     );

    //     if (!$connect) {
    //         return []; // Return empty if connection fails
    //     }

    //     // Set maximum length of description (adjust based on your database column size)
    //     $max_length = 50;
    //     $description = substr($description, 0, $max_length);

    //     // $table_query = "SELECT [No_], [Description], [Extended Description] FROM " . $table . " WHERE [Description] = ?";
    //     $table_query = "SELECT [No_], [Extended Description], [Description] FROM " . $table . " WHERE [Extended Description] = ?";
    //     // $table_query = "SELECT * FROM " . $table . " WHERE [Description] = ?";
    //     // [Base Unit of Measure]
    //     // Extended Description

    //     $result = @odbc_prepare($connect, $table_query); // Suppress errors
    //     @odbc_execute($result, array($description));  // Suppress errors

    //     $all_data = [];

    //     while ($row = @odbc_fetch_array($result)) { // Suppress fetch errors
    //         $all_data[] = $row;
    //     }
    //     // var_dump($all_data);
    //     // exit;
    //     @odbc_free_result($result);
    //     @odbc_close($connect);

    //     return $all_data;
    // }
    public function getItemCodeNav($description, $uom)
    {
        $nav_data = $this->setUpNavConnect(5);
        $table = '[' . $nav_data['sub_db_name'] . '$Item]';

        $connect = @odbc_connect(
            "Driver={SQL Server};Server=" . $nav_data["server_address"] . ";Database=" . $nav_data["sql_dbname"] . ";",
            $nav_data["username"],
            $nav_data["password"]
        );

        if (!$connect) {
            return []; // Return empty if connection fails
        }

        // Set maximum length of description (adjust based on your database column size)
        $max_length = 50;
        $description = substr($description, 0, $max_length);

        // var_dump($description);
        // exit;

        // Adjust query to filter by both description and UOM
        $table_query = "SELECT [No_], [Extended Description], [Description], [Base Unit of Measure] 
                        FROM " . $table . " 
                        WHERE ([Extended Description] = ? OR [Description] = ?)  AND [Base Unit of Measure] = ?";

        // $nav_qty = $this->Manual_po_mod->                

        $result = @odbc_prepare($connect, $table_query);
        @odbc_execute($result, [$description, $description, $uom]);

        $item_code = "";
        var_dump($item_code);

        if ($row = odbc_fetch_array($result)) {
            $item_code = $row["No_"];
        }

        @odbc_free_result($result);
        @odbc_close($connect);

        return $item_code;
        var_dump($item_code);
    }

    function getItemDescNav($exist_item_code)
    { // Navision

        $nav_data = $this->setUpNavConnect(5);

        $table = '[' . $nav_data['sub_db_name'] . '$Item]';
        // $connect = odbc_connect($nav_data['db_name'], $nav_data['username'], $nav_data['password']);
        $connect = odbc_connect("Driver={SQL Server};Server=" . $nav_data["server_address"] . ";Database=" . $nav_data["sql_dbname"] . ";", $nav_data["username"], $nav_data["password"]);

        $table_query = "SELECT [Extended Description] AS item_desc 
                       FROM " . $table . " WHERE [No_]=?";

        $result = odbc_prepare($connect, $table_query);
        odbc_execute($result, array($exist_item_code));

        $description = "";

        if ($row = odbc_fetch_array($result)) {
            $description = $row["item_desc"];
        }

        odbc_free_result($result);
        odbc_close($connect);
        return $description;
    }

    function getItemCodeNav2($item_code)
    { // Navision

        // var_dump($item_code);

        $nav_data = $this->setUpNavConnect(5);

        $table = '[' . $nav_data['sub_db_name'] . '$Item]';
        // $connect = odbc_connect($nav_data['db_name'], $nav_data['username'], $nav_data['password']);
        $connect = odbc_connect("Driver={SQL Server};Server=" . $nav_data["server_address"] . ";Database=" . $nav_data["sql_dbname"] . ";", $nav_data["username"], $nav_data["password"]);

        $table_query = "SELECT [No_] AS item_code 
                       FROM " . $table . " WHERE [No_]=?";

        $result = odbc_prepare($connect, $table_query);
        odbc_execute($result, array($item_code));

        $item_code = "";

        if ($row = odbc_fetch_array($result)) {
            $item_code = $row["item_code"];
        }
        // var_dump($item_code);
        odbc_free_result($result);
        odbc_close($connect);
        return $item_code;
    }

    public function getQtyNav($item_code, $store_id)
    {
        $this->db->select('up_item_code, up_qty');
        $this->db->from('manual_po_upload');
        $this->db->where('manual_po_upload.up_store_id', $store_id);

        if (is_array($item_code)) {
            $this->db->where_in('up_item_code', $item_code);
        } else {
            $this->db->where('up_item_code', $item_code);
        }

        $query = $this->db->get();
        return $query->row_array();
    }

    // public function getQtyNav($item_code, $store_id)
    // {
    //     $this->db->select('manual_po_header.store_id, manual_po_header.mp_hd_id, manual_po_lines.mp_hd_id, manual_po_upload.up_item_code, manual_po_upload.up_qty');
    //     $this->db->from('manual_po_lines');
    //     $this->db->join('manual_po_header', 'manual_po_lines.mp_hd_id = manual_po_header.mp_hd_id', 'inner');
    //     $this->db->join('manual_po_upload', 'manual_po_upload.up_item_code = manual_po_lines.item_code', 'inner');

    //     $this->db->where('manual_po_header.store_id', $store_id);

    //     if (is_array($item_code)) {
    //         $this->db->where_in('manual_po_upload.up_item_code', $item_code);
    //     } else {
    //         $this->db->where('manual_po_upload.up_item_code', $item_code);
    //     }

    //     $query = $this->db->get();
    //     return $query->row_array();
    // }


    public function getManualPoUploadByItemCode($item_code)
    {
        $this->db->select('up_qty');
        $this->db->from('manual_po_upload');
        $this->db->where('up_item_code', $item_code);

        $query = $this->db->get();
        return $query->row_array(); // Return single row
    }

    public function updateNavQtyNosetup($prev_desc, $nav_qty)
    {
        $this->db->where('prev_desc', $prev_desc);
        // $this->db->update('manual_po_lines', ['nav_qty_onhand' => $qty_on_hand], ['item_desc' => $item_desc]);
        $this->db->update('manual_po_lines', ['nav_qty_onhand' => $nav_qty]);
        return $this->db->affected_rows() > 0; // Returns true if successful
    }

    public function updateNavQtyNosetup2($exist_item_code, $nav_qty)
    {
        $nav_qty_value = isset($nav_qty['up_qty']) ? $nav_qty['up_qty'] : 0;

        $this->db->where('item_code', $exist_item_code);
        $this->db->update('manual_po_lines', ['nav_qty_onhand' => $nav_qty_value]);

        return $this->db->affected_rows() > 0;
    }

    public function updateNavQtyOnHand($mp_ln_id, $nav_qty)
    {
        $this->db->where('mp_ln_id', $mp_ln_id);
        $this->db->update('manual_po_lines', ['nav_qty_onhand' => $nav_qty]);
        return $this->db->affected_rows() > 0;
    }

    public function getItemCode($description, $uom)
    {
        $nav_data = $this->setUpNavConnect(5);
        $table = '[' . $nav_data['sub_db_name'] . '$Item]';

        $connect = @odbc_connect(
            "Driver={SQL Server};Server=" . $nav_data["server_address"] . ";Database=" . $nav_data["sql_dbname"] . ";",
            $nav_data["username"],
            $nav_data["password"]
        );

        if (!$connect) {
            return []; // Return empty if connection fails
        }

        $max_length = 50;
        $description = substr($description, 0, $max_length);

        $table_query = "SELECT [No_], [Extended Description], [Description], [Base Unit of Measure] 
                        FROM " . $table . " 
                        WHERE ([Extended Description] = ? OR [Description] = ?)  AND [Base Unit of Measure] = ?";

        // $nav_qty = $this->Manual_po_mod->                

        $result = @odbc_prepare($connect, $table_query);
        @odbc_execute($result, [$description, $description, $uom]);

        $all_data = [];

        while ($row = @odbc_fetch_array($result)) {
            $all_data[] = $row;
        }

        @odbc_free_result($result);
        @odbc_close($connect);

        return $all_data;
    }

    // public function getNav($item_code)
    // {
    //     $this->db->select('manual_po_upload.up_qty'); // Select only the required column
    //     $this->db->from('manual_po_upload');
    //     $this->db->where('manual_po_upload.up_item_code', $item_code);

    //     $query = $this->db->get(); // Execute the query

    //     return $query->row_array(); // Return a single row as an associative array
    // }


    public function updateItemCode($prev_desc, $item_code, $new_itemDesc)
    {
        $this->db->where('prev_desc', $prev_desc);
        $this->db->update('manual_po_lines', [
            'item_desc' => $new_itemDesc,
            'item_code' => $item_code,
            'setup_status' => 0
        ]);

        return $this->db->affected_rows() > 0; // Returns true if the update was successful
    }

    // public function insert_batch($extracted_data)
    // {
    //     if (empty($extracted_data)) {
    //         return false;
    //     }

    //     foreach ($extracted_data as $row) {
    //         // Check if the item code exists
    //         $this->db->select('up_item_code');
    //         $this->db->where('up_item_code', $row['up_item_code']);
    //         $existing = $this->db->get('manual_po_upload')->row();

    //         if ($existing) {
    //             // If exists, update up_qty with new value
    //             $this->db->where('up_item_code', $row['up_item_code']);
    //             $this->db->update('manual_po_upload', ['up_qty' => $row['up_qty']]);
    //         } else {
    //             // If not, insert new record
    //             $this->db->insert('manual_po_upload', $row);
    //         }
    //     }
    //     return true;
    // }

    public function insert_batch($extracted_data)
    {
        if (empty($extracted_data) || !is_array($extracted_data)) {
            return false;
        }

        foreach ($extracted_data as $data) {
            // Ensure the required keys exist to avoid "Undefined index" error
            if (!isset($data['up_store_id'], $data['up_item_code'], $data['up_qty'])) {
                log_message('error', 'Missing required keys in extracted data: ' . print_r($data, true));
                continue; // Skip invalid records
            }

            // Check if record with same store ID and item code exists
            $this->db->select('up_qty');
            $this->db->where('up_store_id', $data['up_store_id']);
            $this->db->where('up_item_code', $data['up_item_code']);
            $existingRecord = $this->db->get('manual_po_upload')->row();

            if ($existingRecord) {
                // If exists, update up_qty with new value
                $this->db->where('up_store_id', $data['up_store_id']);
                $this->db->where('up_item_code', $data['up_item_code']);
                $this->db->update('manual_po_upload', ['up_qty' => $data['up_qty']]);
            } else {
                // If not, insert new record
                $this->db->insert('manual_po_upload', $data);
            }
        }

        return true;
    }


    public function navDocExistsSI($nav_doc_no_SI)
    {
        $this->db->where('TRIM(nav_doc_no_SI)', trim($nav_doc_no_SI));
        // $this->db->where('doc_status', 0); // Explicitly check for doc_status = 1
        $query = $this->db->get('manual_po_header');

        return $query->num_rows() > 0;
    }

    public function navDocExistsDR($nav_doc_no_DR)
    {
        $this->db->where('TRIM(nav_doc_no_DR)', trim($nav_doc_no_DR));
        $query = $this->db->get('manual_po_header');

        return $query->num_rows() > 0;
    }

    public function getPoDetailsByMpHdId($mp_hd_id)
    {
        $this->db->select('manual_po_header.*, l.*');
        $this->db->from('manual_po_header');
        $this->db->join('manual_po_lines l', 'h.mp_hd_id = l.mp_hd_id', 'left');
        $this->db->where('h.mp_hd_id', $mp_hd_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array(); // Return all records as an array
        } else {
            return false; // No data found
        }
    }

    public function getPoData2($start = 0, $length = 10, $column_index = 0, $sort_direction = 'asc', $search = '')
    {
        $columns = ['vendor_code', 'vendor_name', 'date_generated', 'status'];
        $sort_column = $columns[$column_index];

        $this->db->select('manual_po_header.*');
        $this->db->from('manual_po_header');
        $this->db->group_by('manual_po_header.vendor_code');

        // Ensure only vendors with setup_status = 1 in manual_po_lines are included
        $this->db->join('manual_po_lines', 'manual_po_header.mp_hd_id = manual_po_lines.mp_hd_id', 'inner');
        // $this->db->where('manual_po_lines.setup_status', 1);
        $this->db->where('manual_po_lines.data_status', 1);

        if (!empty($search)) {
            $dateFormatted = date('Y-m-d', strtotime($search));

            $this->db->group_start();
            $this->db->or_like('manual_po_header.vendor_code', $search);
            $this->db->or_like('manual_po_header.vendor_name', $search);
            $this->db->or_like('manual_po_header.date_generated', $dateFormatted);
            $this->db->group_end();
        }

        $filtered_records = $this->db->count_all_results('', false);

        // Apply sorting and limit
        $this->db->order_by($sort_column, $sort_direction);
        $this->db->limit($length, $start);

        $query = $this->db->get();
        $data = $query->result_array();

        return [
            'total_records' => $this->db->count_all('manual_po_header'),
            'filtered_records' => $filtered_records,
            'data' => $data
        ];
    }

    public function getPoData3($start = 0, $length = 10, $column_index = 0, $sort_direction = 'asc', $search = '')
    {
        $columns = ['vendor_code', 'vendor_name', 'date_generated', 'status'];
        $sort_column = $columns[$column_index];

        $this->db->select('manual_po_header.*');
        $this->db->from('manual_po_header');
        $this->db->group_by('vendor_code');
        $this->db->where('manual_po_header.vend_type', 'NO SETUP');

        if (!empty($search)) {
            $dateFormatted = date('Y-m-d', strtotime($search));

            $this->db->group_start();
            $this->db->or_like('manual_po_header.vendor_code', $search);
            $this->db->or_like('manual_po_header.vendor_name', $search);
            $this->db->or_like('manual_po_header.date_generated', $dateFormatted);
            $this->db->group_end();
        }

        $filtered_records = $this->db->count_all_results('', false);

        // Apply sorting and limit
        // $this->db->order_by($sort_column, $sort_direction);
        // $this->db->limit($length, $start);

        $query = $this->db->get();
        $data = $query->result_array();

        return [
            'total_records' => $this->db->count_all('manual_po_header'),
            'filtered_records' => $filtered_records,
            'data' => $data
        ];
    }


    public function getPoDetailsById2($id, $start, $length, $order = [], $search = '')
    {
        $this->db->select('
        manual_po_header.vendor_code,
        manual_po_header.vendor_name,
        manual_po_lines.prev_desc,
        manual_po_lines.mp_ln_id,
        manual_po_lines.setup_status,
        manual_po_lines.item_desc,
        manual_po_lines.uom,
        manual_po_lines.variant,
        manual_po_lines.data_status,
        manual_po_lines.item_code,
    ');

        $this->db->from('manual_po_lines');
        $this->db->join('manual_po_header', 'manual_po_header.mp_hd_id = manual_po_lines.mp_hd_id');
        $this->db->where('manual_po_header.vendor_code', $id);
        // $this->db->where('manual_po_lines.setup_status', 1);
        $this->db->where('manual_po_lines.data_status', 1);
        $this->db->group_by([
            // 'manual_po_lines.setup_status',
            'manual_po_lines.prev_desc',
            // 'manual_po_lines.item_desc',
            // 'manual_po_lines.uom',
            // 'manual_po_lines.variant',
            // 'manual_po_lines.data_status',
            // 'manual_po_lines.item_code'
        ]);
        // Apply search filters
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('manual_po_lines.item_code', $search);
            $this->db->or_like('manual_po_lines.item_desc', $search);
            $this->db->or_like('manual_po_lines.uom', $search);
            $this->db->group_end();
        }

        // **GROUP BY item_desc, uom, variant**
        // $this->db->group_by(['manual_po_lines.item_desc', 'manual_po_lines.uom', 'manual_po_lines.variant']);
        $this->db->group_by(['manual_po_lines.prev_desc']);
        $this->db->order_by('manual_po_lines.setup_status', 'DESC');

        // Get the total number of records before applying limit
        $filtered_records = $this->db->count_all_results('', false);

        // Apply ordering if specified
        if (!empty($order) && isset($order[0]['column'])) {
            $columns = [
                'manual_po_lines.item_desc',
                'manual_po_lines.uom',
                'manual_po_lines.variant'
            ];

            $column_index = $order[0]['column'];
            $direction = $order[0]['dir'];

            if (isset($columns[$column_index])) {
                $this->db->order_by($columns[$column_index], $direction);
            }
        } else {
            $this->db->order_by('manual_po_lines.item_desc', 'ASC');
        }

        // Apply pagination
        $this->db->limit($length, $start);

        // Execute final query
        $query = $this->db->get();
        $data = $query->result_array();

        return [
            'filtered_records' => $filtered_records,
            'data' => $data
        ];
    }



    public function countAllPoRecords2($id, $search = null)
    {
        $this->db->select('COUNT(DISTINCT CONCAT(manual_po_lines.item_desc, "-", manual_po_lines.uom, "-", manual_po_lines.variant)) as total_records', false);
        $this->db->from('manual_po_lines');
        $this->db->join('manual_po_header', 'manual_po_header.mp_hd_id = manual_po_lines.mp_hd_id');
        $this->db->where('manual_po_header.vendor_code', $id);
        $this->db->where('manual_po_lines.setup_status', 1);

        // Apply search filters
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('manual_po_lines.item_code', $search);
            $this->db->or_like('manual_po_lines.item_desc', $search);
            $this->db->or_like('manual_po_lines.uom', $search);
            $this->db->group_end();
        }

        $query = $this->db->get();
        $result = $query->row();

        return $result ? (int) $result->total_records : 0;
    }

    // public function getLnData2($prev_desc)
    // // public function getLnData2($prev_desc)
    // {
    //     $this->db->select('item_code, item_desc, variant, uom, prev_desc');
    //     $this->db->from('manual_po_lines');
    //     $this->db->where('prev_desc', $prev_desc);
    //     $this->db->group_by('prev_desc');

    //     $query = $this->db->get();
    //     return $query->result_array();
    //     // var_dump($query);
    // }

    public function getLnData2($mp_ln_id)
    {
        $this->db->select('mp_ln_id, item_code, item_desc,variant, uom, prev_desc');
        $this->db->from('manual_po_lines');
        $this->db->where('mp_ln_id', $mp_ln_id);
        // $this->db->group_by('prev_desc');

        $query = $this->db->get();
        return $query->result_array();
    }

    function getItemDescFromNav2($item_code)
    { // Navision

        $nav_data = $this->setUpNavConnect(5);

        $table = '[' . $nav_data['sub_db_name'] . '$Item]';
        // $connect = odbc_connect($nav_data['db_name'], $nav_data['username'], $nav_data['password']);
        $connect = odbc_connect("Driver={SQL Server};Server=" . $nav_data["server_address"] . ";Database=" . $nav_data["sql_dbname"] . ";", $nav_data["username"], $nav_data["password"]);

        $table_query = "SELECT [Description] AS item_desc 
                       FROM " . $table . " WHERE [No_]=?";

        $result = odbc_prepare($connect, $table_query);
        odbc_execute($result, array($item_code));

        $description = "";

        if ($row = odbc_fetch_array($result)) {
            $description = $row["item_desc"];
        }

        odbc_free_result($result);
        odbc_close($connect);
        return $description;
    }

    function getUomsFromNav2($item_code)
    { // Navision

        $nav_data = $this->setUpNavConnect(5);

        $table = '[' . $nav_data['sub_db_name'] . '$Item Unit of Measure]';
        // $connect = odbc_connect($nav_data['db_name'], $nav_data['username'], $nav_data['password']);
        $connect = odbc_connect("Driver={SQL Server};Server=" . $nav_data["server_address"] . ";Database=" . $nav_data["sql_dbname"] . ";", $nav_data["username"], $nav_data["password"]);

        $table_query = "SELECT REPLACE([Code],'''','') AS uom, [Qty_ per Unit of Measure] AS qty_uom 
                       FROM " . $table . " WHERE [Item No_]=?";

        $result = odbc_prepare($connect, $table_query);
        odbc_execute($result, array($item_code));

        $uoms = array();

        while ($row = odbc_fetch_array($result)) {
            //  $uom["uom"] = $row["uom"];
            //  $uom["qty_uom"] = round($row["qty_uom"],10);
            //  $uoms[] = $uom;
            $uoms[] = $row["uom"];
        }

        odbc_free_result($result);
        odbc_close($connect);
        return $uoms;
    }

    function getVariantsFromNav2($item_code)
    { // Navision

        $nav_data = $this->setUpNavConnect(5);

        $table = '[' . $nav_data['sub_db_name'] . '$Item Variant]';
        // $connect = odbc_connect($nav_data['db_name'], $nav_data['username'], $nav_data['password']);
        $connect = odbc_connect("Driver={SQL Server};Server=" . $nav_data["server_address"] . ";Database=" . $nav_data["sql_dbname"] . ";", $nav_data["username"], $nav_data["password"]);

        // $table_query = "SELECT [Code] AS variant FROM " . $table . " WHERE [Item No_]=?";
        $table_query = "SELECT COALESCE([Description 2], '') + ' ' + COALESCE([Description], '') AS variant FROM " . $table . " WHERE [Item No_]=?";

        $result = odbc_prepare($connect, $table_query);
        odbc_execute($result, array($item_code));

        $variants = array();

        while ($row = odbc_fetch_array($result)) {
            $variants[] = $row["variant"];
        }

        odbc_free_result($result);
        odbc_close($connect);
        return $variants;
    }

    public function saveItem2($data, $prev_itemCode, $prev_itemDesc, $prev_variant, $prev_uom, $prev_desc)
    {
        // $this->db->where('item_code', $prev_itemCode);
        // $this->db->where('item_desc', $prev_itemDesc);
        // $this->db->where('variant', $prev_variant);
        // $this->db->where('uom', $prev_uom);
        $this->db->where('prev_desc', $prev_desc);
        // $this->db->where('item_desc', $prev_itemDesc);
        // $this->db->where('item_code', $prev_itemCode);
        $this->db->update('manual_po_lines', $data);
        // var_dump($query);
        // exit;
    }

    public function get_all_rows2($mp_hd_id)
    {
        $this->db->select('manual_po_lines.*, manual_po_header.*');
        $this->db->from('manual_po_lines');
        $this->db->join('manual_po_header', 'manual_po_header.mp_hd_id = manual_po_lines.mp_hd_id', 'inner');
        $this->db->where('manual_po_lines.mp_hd_id', $mp_hd_id);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_all_rows3($vendor_code)
    {
        $this->db->select('manual_po_lines.*, manual_po_header.*');
        $this->db->from('manual_po_lines');
        $this->db->join('manual_po_header', 'manual_po_header.mp_hd_id = manual_po_lines.mp_hd_id', 'inner');
        $this->db->where('manual_po_header.vendor_code', $vendor_code);
        $this->db->where('manual_po_lines.setup_status', 1);
        $this->db->group_by('manual_po_lines.prev_desc');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getVendType($vendor_code)
    {
        $this->db->select('no_, name_, vend_type');
        $this->db->from('po_calendar');
        $this->db->where('po_calendar.no_', $vendor_code);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function updateVendorData($vendor_code, $vendor_name, $vend_type)
    {
        $data = [
            'vendor_name' => $vendor_name,
            'vend_type' => $vend_type
        ];

        $this->db->where('vendor_code', $vendor_code);
        $this->db->update('manual_po_header', $data);
    }

    public function  getAllSod($vendor_code)
    {
        $this->db->select('sod_code');
        $this->db->from('manual_po_sod');
        $this->db->where('manual_po_sod.sod_vend_code', $vendor_code);
        $query = $this->db->get();

        return $query->row_array();
    }
}
