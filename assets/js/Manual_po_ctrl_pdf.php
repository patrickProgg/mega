<?php

class Manual_po_ctrl_pdf extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('Manual_po_mod_pdf');
        $this->load->library('pdf'); // Load the PDF library
        // $this->load->library('ExcelGenerator'); // Load the library
        // $this->load->library('../third_party/xlsx');
        $this->load->model('Acct_mod');
        $this->load->model('Manual_po_mod');
    }

    public function generate_pdf($r_no = null, $scode)
    {
        ob_start();
        $user_details_type = $this->Acct_mod->getUserDetailsById($_SESSION["mms_user"]);

        $po_details = $this->Manual_po_mod_pdf->getPoDetailsById($r_no, true);

        if (empty($po_details)) {
            throw new Exception("No data found for PO.");
        }

        $header_info = $po_details[0];

        $user_details = $this->Acct_mod->getUserDetailsById($user_details_type["user_id"]);
        $emp_id = (isset($user_details)) ? $user_details["emp_id"] : "";
        $emp_details = $this->Acct_mod->retrieveEmployeeName($emp_id);
        $emp_name = (isset($emp_details)) ? $emp_details["name"] : "";
        $row["buyer_name"] = $emp_name;

        $user_details = $this->Acct_mod->getUserDetailsById($header_info["status_by"]);
        $emp_id = (isset($user_details)) ? $user_details["emp_id"] : "";
        $emp_details = $this->Acct_mod->retrieveEmployeeName($emp_id);
        $emp_name = (isset($emp_details)) ? $emp_details["name"] : "";
        $row["head_name"] = $emp_name;

        $buyer =  $row["buyer_name"];
        $head =  $row["head_name"];

        $reorder_date = isset($header_info["reorder_date"]) ? date('F d, Y', strtotime($header_info["reorder_date"])) : 'N/A';
        $date_generated = isset($header_info["date_generated"]) ? date('F d, Y -- h:i A', strtotime($header_info["date_generated"])) : 'N/A';
        $docNo = 'MMSMP-' . strtoupper($header_info["value_"]) . '-' . str_pad($r_no, 7, '0', STR_PAD_LEFT);

        // $store_id = $user_details_type['store_id'];

        if (isset($scode)) {
            $header_data = array(
                "Reorder Date"   => $reorder_date,
                "Document No."   => $docNo,
                // "Supplier Code"  => isset($header_info["vendor_code"]) ? $header_info["vendor_code"] : 'N/A',
                "Supplier Code"  =>  $scode,
                "Status"         => isset($header_info["status"]) ? strtoupper($header_info["status"]) : 'N/A',
                "Supplier Name"  => isset($header_info["vendor_name"]) ? $header_info["vendor_name"] : 'N/A',
                "Date Generated" => $date_generated,
            );
        } else {
            // Define Header Fields
            $header_data = array(
                "Reorder Date"   => $reorder_date,
                "Document No."   => $docNo,
                "Supplier Code"  => isset($header_info["vendor_code"]) ? $header_info["vendor_code"] : 'N/A',
                "Status"         => isset($header_info["status"]) ? strtoupper($header_info["status"]) : 'N/A',
                "Supplier Name"  => isset($header_info["vendor_name"]) ? $header_info["vendor_name"] : 'N/A',
                "Date Generated" => $date_generated,
            );
        }
        // if ($store_id == 2 || $store_id == 3) {
        //     $header_data = array(
        //         "Reorder Date"   => $reorder_date,
        //         "Document No."   => $docNo,
        //         // "Supplier Code"  => isset($header_info["vendor_code"]) ? $header_info["vendor_code"] : 'N/A',
        //         "Supplier Code"  =>  $scode,
        //         "Status"         => isset($header_info["status"]) ? strtoupper($header_info["status"]) : 'N/A',
        //         "Supplier Name"  => isset($header_info["vendor_name"]) ? $header_info["vendor_name"] : 'N/A',
        //         "Date Generated" => $date_generated,
        //     );
        // } else {
        //     // Define Header Fields
        //     $header_data = array(
        //         "Reorder Date"   => $reorder_date,
        //         "Document No."   => $docNo,
        //         "Supplier Code"  => isset($header_info["vendor_code"]) ? $header_info["vendor_code"] : 'N/A',
        //         "Status"         => isset($header_info["status"]) ? strtoupper($header_info["status"]) : 'N/A',
        //         "Supplier Name"  => isset($header_info["vendor_name"]) ? $header_info["vendor_name"] : 'N/A',
        //         "Date Generated" => $date_generated,
        //     );
        // }

        // Initialize TCPDF with Letter size (8.5 x 11 inches)
        $this->ppdf = new TCPDF('L', 'mm', array(215.9, 279.4), true, 'UTF-8', false);
        $this->ppdf->SetTitle($docNo);
        $this->ppdf->SetMargins(5, 15, 5, true); // Left, Top, Right margins
        $this->ppdf->setPrintHeader(false);
        $this->ppdf->SetFont('', '', 9, '', true);
        $this->ppdf->SetAutoPageBreak(true, 1);
        $this->ppdf->AddPage();


        // Print Header (without border)
        foreach (array_chunk($header_data, 2, true) as $row) {
            foreach ($row as $label => $value) {
                $this->ppdf->SetFont('', '', 9);
                $this->ppdf->Cell(50, 6, $label . ":", 0, 0);

                $this->ppdf->SetFont('', 'B', 9);
                $this->ppdf->Cell(90, 6, $value, 0, 0);
            }
            $this->ppdf->Ln();
        }

        $this->ppdf->Ln(5);

        // Function to print table headers
        function printTableHeaders($pdf)
        {
            $pdf->SetFont('', 'B', 8);
            $pdf->MultiCell(20, 4, "ITEM\nCODE", 0, 'L', 0, 0);
            $pdf->MultiCell(100, 4, "DESCRIPTION", 0, 'L', 0, 0);
            $pdf->MultiCell(40, 4, "VARIANT", 0, 'L', 0, 0);
            $pdf->MultiCell(10, 4, "UOM", 0, 'L', 0, 0);
            $pdf->MultiCell(20, 4, "QTY\nON HAND", 0, 'L', 0, 0);
            $pdf->MultiCell(20, 4, "ORIG QTY\nON HAND", 0, 'L', 0, 0);
            $pdf->MultiCell(30, 4, "SUGGESTED\nREORDER QTY", 0, 'L', 0, 0);
            $pdf->MultiCell(30, 4, "ORIG SUGGESTED\nREORDER QTY", 0, 'L', 0, 0);
            $pdf->Ln();
            $pdf->Ln(2);
            $pdf->Cell(269, 0, '', 'T', 1, 'C');
        }

        // Print table headers for the first time
        printTableHeaders($this->ppdf);

        // Table Data
        $this->ppdf->SetFont('', '', 8);

        function addPageNumber($pdf)
        {
            $pdf->SetFont('', 'I', 7);
            $pdf->SetY(5); // Position at the bottom of the page
            $pdf->SetX(-10); // Move to the right edge
            $pdf->Cell(0, 5, 'Page ' . $pdf->getAliasNumPage() . ' of ' . $pdf->getAliasNbPages(), 0, 1, 'C');
        }

        foreach ($po_details as $item) {

            $vend_types = explode(',', $item['vend_type']);

            if ((in_array('SI', $vend_types) && $item['reorder_qty_SI'] == 0) ||
                (in_array('DR', $vend_types) && $item['reorder_qty'] == 0)
            ) {
                continue; // Skip this row
            }

            if ($this->ppdf->GetY() + 10 > $this->ppdf->getPageHeight() - 10) {
                addPageNumber($this->ppdf);
                $this->ppdf->AddPage();
                printTableHeaders($this->ppdf);
            }

            $this->ppdf->SetFont('', '', 8);
            $this->ppdf->Cell(20, 3, $item['item_code'], 0);
            $this->ppdf->Cell(100, 3, $item['item_desc'], 0);
            $this->ppdf->Cell(40, 3, $item['variant'], 0);
            $this->ppdf->Cell(10, 3, $item['uom'], 0);
            $this->ppdf->Cell(20, 3, $item['qty_onhand'], 0, 'R', 0, 0);
            $this->ppdf->Cell(20, 3, $item['orig_qty_onhand'], 0, 'R', 0, 0);

            // $vend_types = explode(',', $item['vend_type']);

            if (in_array('SI', $vend_types) && in_array('DR', $vend_types)) {
                $this->ppdf->SetFont('', 'B', 9);
                $this->ppdf->Cell(10, 3, "SI:", 0, 0, 'R');
                $this->ppdf->SetFont('', '', 9);
                $this->ppdf->Cell(20, 3, $item['reorder_qty_SI'], 0, 0, 'L');

                $this->ppdf->SetFont('', 'B', 9);
                $this->ppdf->Cell(10, 3, "SI:", 0, 0, 'R');
                $this->ppdf->SetFont('', '', 9);
                $this->ppdf->Cell(20, 3, $item['orig_reorder_qty_SI'], 0, 1, 'L');

                $this->ppdf->SetFont('', 'B', 9);
                $this->ppdf->Cell(220, 3, "DR:", 0, 0, 'R');
                $this->ppdf->SetFont('', '', 9);
                $this->ppdf->Cell(20, 3, $item['reorder_qty'], 0, 0, 'L');

                $this->ppdf->SetFont('', 'B', 9);
                $this->ppdf->Cell(10, 3, "DR:", 0, 0, 'R');
                $this->ppdf->SetFont('', '', 9);
                $this->ppdf->Cell(20, 3, $item['orig_reorder_qty'], 0, 1, 'L');
            } else {
                if (in_array('SI', $vend_types)) {
                    $this->ppdf->SetFont('', 'B', 9);
                    $this->ppdf->Cell(10, 3, "SI:", 0, 0, 'R');
                    $this->ppdf->SetFont('', '', 9);
                    $this->ppdf->Cell(20, 3, $item['reorder_qty_SI'], 0, 0, 'L');

                    $this->ppdf->SetFont('', 'B', 9);
                    $this->ppdf->Cell(10, 3, "SI:", 0, 0, 'R');
                    $this->ppdf->SetFont('', '', 9);
                    $this->ppdf->Cell(20, 3, $item['orig_reorder_qty_SI'], 0, 1, 'L');
                }

                if (in_array('DR', $vend_types)) {
                    $this->ppdf->SetFont('', 'B', 9);
                    $this->ppdf->Cell(10, 3, "DR:", 0, 0, 'R');
                    $this->ppdf->SetFont('', '', 9);
                    $this->ppdf->Cell(20, 3, $item['reorder_qty'], 0, 0, 'L');

                    $this->ppdf->SetFont('', 'B', 9);
                    $this->ppdf->Cell(10, 3, "DR:", 0, 0, 'R');
                    $this->ppdf->SetFont('', '', 9);
                    $this->ppdf->Cell(20, 3, $item['reorder_qty'], 0, 1, 'L');
                }
            }


            $this->ppdf->Ln(1);
            $this->ppdf->Cell(269, 0, '', 'T', 1, 'C');
        }

        $this->ppdf->Cell(95, 10, 'Prepared By:', 0, 0, 'L');
        $this->ppdf->Cell(95, 10, 'Approved By:', 0, 1, 'L');

        $this->ppdf->Ln(1);

        $this->ppdf->SetFont('Helvetica', 'B', 10); // Use Helvetica (built-in)
        $this->ppdf->Cell(95, 0, strtoupper($buyer), 0, 0, 'L');
        $this->ppdf->Cell(95, 0, strtoupper($head), 0, 1, 'L');
        $this->ppdf->SetFont('Helvetica', '', 10); // Reset font to normal (optional)


        $this->ppdf->Line(6, $this->ppdf->GetY() + 2, 80, $this->ppdf->GetY() + 2); // Line under Prepared By
        $this->ppdf->Line(101, $this->ppdf->GetY() + 2, 175, $this->ppdf->GetY() + 2); // Line under Approved By

        $this->ppdf->Ln(2);

        $this->ppdf->Cell(95, 5, '(Signature over Printed name)', 0, 0, 'L');
        $this->ppdf->Cell(95, 5, '(Signature over Printed name)', 0, 1, 'L');

        $this->ppdf->Ln(2);

        $x = $this->ppdf->GetX() + 20; // Adjust X to start after "Date:"
        $y = $this->ppdf->GetY() + 5; // Position slightly below the text

        $this->ppdf->Cell(95, 8, 'Date:           ', 0, 0, 'L');

        $this->ppdf->Line($x, $y, $x + 35, $y);

        $x = $this->ppdf->GetX() + 20; // Adjust X to start after "Date:"
        $y = $this->ppdf->GetY() + 5; // Position slightly below the text

        $this->ppdf->Cell(95, 8, 'Date:           ', 0, 1, 'L');

        $this->ppdf->Line($x, $y, $x + 35, $y);

        addPageNumber($this->ppdf);

        ob_clean();
        $this->ppdf->Output("{$docNo}.pdf", 'I');
        exit;
    }

    public function generate_pdf_nosetup($r_no = null, $scode)
    {
        // var_dump($scode);
        // Prevent unwanted output
        ob_start();

        $user_details_type = $this->Acct_mod->getUserDetailsById($_SESSION["mms_user"]);
        $store_id = $user_details_type['store_id'];


        // Fetch PO Details
        $po_details = $this->Manual_po_mod_pdf->getPoDetailsById($r_no);
        $po_calendar = $this->Manual_po_mod_pdf->getPoCalendar($r_no);

        // var_dump($po_details);
        // exit;

        // Handle missing data properly
        if (empty($po_details)) {
            // throw new Exception("No data found for PO.");
        }

        // Extract first record for the header
        $header_info = $po_details[0];
        $header_info2 = $po_calendar[0];

        $user_details = $this->Acct_mod->getUserDetailsById($user_details_type["user_id"]);
        $emp_id = (isset($user_details)) ? $user_details["emp_id"] : "";
        $emp_details = $this->Acct_mod->retrieveEmployeeName($emp_id);
        $emp_name = (isset($emp_details)) ? $emp_details["name"] : "";
        $row["buyer_name"] = $emp_name;

        $user_details = $this->Acct_mod->getUserDetailsById($header_info["status_by"]);
        $emp_id = (isset($user_details)) ? $user_details["emp_id"] : "";
        $emp_details = $this->Acct_mod->retrieveEmployeeName($emp_id);
        $emp_name = (isset($emp_details)) ? $emp_details["name"] : "";
        $row["head_name"] = $emp_name;

        $store_id =  isset($header_info["store_id"]) ? $header_info["store_id"] :  "";
        $store_details = $this->Manual_po_mod->get_store_details_by_id($store_id);

        $header = $store_details["header_name"];
        $address = $store_details["address"];
        $tel = $store_details["tel"];
        $tin = $store_details["tin"];
        $buyer =  $row["buyer_name"];
        $head =  $row["head_name"];

        // Format dates
        $reorder_date = isset($header_info["reorder_date"]) ? date('F d, Y', strtotime($header_info["reorder_date"])) : 'N/A';
        $date_generated = isset($header_info["date_generated"]) ? date('F d, Y -- h:i A', strtotime($header_info["date_generated"])) : 'N/A';
        $docNo = 'MMSMP-' . strtoupper($header_info["value_"]) . '-' . str_pad($r_no, 7, '0', STR_PAD_LEFT);

        if (isset($scode)) {
            // Define Header Fields
            $header_data = array(
                // "Vendor Code"  => isset($header_info["vendor_code"]) ? $header_info["vendor_code"] : 'N/A',
                "Vendor Code"  => $scode,
                "Vendor Address"  =>  isset($header_info2["address"]) ? $header_info2["address"] :  "",
                "Vendor Name"  => isset($header_info["vendor_name"]) ? $header_info["vendor_name"] : 'N/A',
                "Posting Date" => $date_generated,
                "Document No."   => $docNo,
            );
        } else {
            $header_data = array(
                "Vendor Code"  => isset($header_info["vendor_code"]) ? $header_info["vendor_code"] : 'N/A',
                // "Vendor Code"  => $scode,
                "Vendor Address"  =>  isset($header_info2["address"]) ? $header_info2["address"] :  "",
                "Vendor Name"  => isset($header_info["vendor_name"]) ? $header_info["vendor_name"] : 'N/A',
                "Posting Date" => $date_generated,
                "Document No."   => $docNo,
            );
        }

        // if ($store_id == 2 || $store_id == 3) {
        //     // Define Header Fields
        //     $header_data = array(
        //         // "Vendor Code"  => isset($header_info["vendor_code"]) ? $header_info["vendor_code"] : 'N/A',
        //         "Vendor Code"  => $scode,
        //         "Vendor Address"  =>  isset($header_info2["address"]) ? $header_info2["address"] :  "",
        //         "Vendor Name"  => isset($header_info["vendor_name"]) ? $header_info["vendor_name"] : 'N/A',
        //         "Posting Date" => $date_generated,
        //         "Document No."   => $docNo,
        //     );
        // } else {
        //     $header_data = array(
        //         "Vendor Code"  => isset($header_info["vendor_code"]) ? $header_info["vendor_code"] : 'N/A',
        //         // "Vendor Code"  => $scode,
        //         "Vendor Address"  =>  isset($header_info2["address"]) ? $header_info2["address"] :  "",
        //         "Vendor Name"  => isset($header_info["vendor_name"]) ? $header_info["vendor_name"] : 'N/A',
        //         "Posting Date" => $date_generated,
        //         "Document No."   => $docNo,
        //     );
        // }


        // Initialize TCPDF with Letter size (8.5 x 11 inches)
        $this->ppdf = new TCPDF('P', 'mm', array(215.9, 279.4), true, 'UTF-8', false);
        $this->ppdf->SetTitle($docNo);
        $this->ppdf->SetMargins(5, 12, 5, true); // Left, Top, Right margins
        $this->ppdf->setPrintHeader(false);
        $this->ppdf->SetFont('', '', 9, '', true);
        $this->ppdf->SetAutoPageBreak(true, 1);
        $this->ppdf->AddPage();

        // Set font for the title
        $this->ppdf->SetFont('', 'B', 12);
        $this->ppdf->Cell(0, 0, $header, 0, 5, 'C');
        $this->ppdf->Ln(1);
        $this->ppdf->SetFont('', '', 10);
        $this->ppdf->Cell(0, 0, $address, 0, 1, 'C');
        $this->ppdf->Cell(0, 0, $tel, 0, 1, 'C');
        $this->ppdf->Cell(0, 0, $tin, 0, 1, 'C');
        $this->ppdf->SetFont('', 'B', 14);
        $this->ppdf->Cell(0, 10, 'Suggested Purchase Order', 0, 1, 'C');

        $this->ppdf->Ln(4);

        // Print Header (without border)
        foreach (array_chunk($header_data, 2, true) as $row) {
            foreach ($row as $label => $value) {
                $this->ppdf->SetFont('', '', 9);
                $this->ppdf->Cell(35, 6, $label . ":", 0, 0);

                $this->ppdf->SetFont('', 'B', 9);
                $this->ppdf->Cell(60, 6, $value, 0, 0);
            }
            $this->ppdf->Ln();
        }

        $this->ppdf->Ln(5);

        // Function to print table headers
        function printTableHeader($pdf)
        {
            $pdf->SetFont('', 'B', 8);
            $pdf->MultiCell(30, 4, "STOCK\nCODE", 0, 'L', 0, 0);
            $pdf->MultiCell(100, 4, "DESCRIPTION", 0, 'L', 0, 0);
            $pdf->MultiCell(20, 4, "QUANTITY", 0, 'L', 0, 0);
            $pdf->MultiCell(15, 4, "UOM", 0, 'L', 0, 0);
            $pdf->MultiCell(20, 4, "UNIT PRICE", 0, 'L', 0, 0);
            $pdf->MultiCell(25, 4, "AMOUNT", 0, 'L', 0, 0);

            $pdf->Ln();
            $pdf->Ln(5);
            $pdf->Cell(206, 0, '', 'T', 1, 'C');
        }

        // Print table headers for the first time
        printTableHeader($this->ppdf);

        // Table Data
        $this->ppdf->SetFont('', '', 8);

        function addPageNumbers($pdf)
        {
            $pdf->SetFont('', 'I', 7);
            $pdf->SetY(5); // Position at the bottom of the page
            $pdf->SetX(-10); // Move to the right edge
            $pdf->Cell(0, 5, 'Page ' . $pdf->getAliasNumPage() . ' of ' . $pdf->getAliasNbPages(), 0, 1, 'C');
        }

        foreach ($po_details as $item) {
            $vend_types = explode(',', $item['vend_type']);

            if ((in_array('SI', $vend_types) && $item['reorder_qty_SI'] == 0) ||
                (in_array('DR', $vend_types) && $item['reorder_qty'] == 0)
            ) {
                continue; // Skip this row
            }

            if ($this->ppdf->GetY() + 10 > $this->ppdf->getPageHeight() - 10) {
                addPageNumbers($this->ppdf);
                $this->ppdf->AddPage();
                printTableHeader($this->ppdf);
            }

            $this->ppdf->SetFont('', '', 8);
            $this->ppdf->Cell(30, 3, $item['item_code'], 0);
            $this->ppdf->Cell(100, 3, $item['item_desc'], 0);

            if (in_array('SI', $vend_types)) {
                $this->ppdf->Cell(20, 3, $item['reorder_qty_SI'], 0);
            } else if (in_array('DR', $vend_types)) {
                $this->ppdf->Cell(20, 3, $item['reorder_qty'], 0);
            }

            // $this->ppdf->Cell(30, 3, $item['qty_onhand'], 0);
            $this->ppdf->Cell(23, 3, $item['uom'], 0);
            $this->ppdf->Cell(17, 3, '-', 0);
            $this->ppdf->Cell(20, 3, '-', 0);
            $this->ppdf->Ln(6);
            // $this->ppdf->Cell(269, 0, '', 'T', 1, 'C');
            $this->ppdf->Cell(206, 0, '', 'T', 1, 'C');
        }

        $this->ppdf->SetFont('', '', 8);
        $this->ppdf->Cell(160, 0, 'Total Amount Due:', 0, 0, 'R');
        $this->ppdf->SetFont('', '', 8);
        $this->ppdf->Cell(40, 0, 'Total Amount Sum:', 0, 0, 'R');

        // Move to the next line for the third cell
        $this->ppdf->Ln(5);

        $this->ppdf->SetFont('', '', 10);
        // $this->ppdf->Cell(0, 0, 'Prepared By: ' . $buyer, 0, 1, 'L');
        // $this->ppdf->Ln(1); // Add space

        // $this->ppdf->Cell(0, 0, 'Approved By: ' . $head, 0, 1, 'L');
        // $now = date("m/d/Y");
        // $date_now = new DateTime($now);

        // Prepared By and Approved By headers

        $this->ppdf->Cell(95, 10, 'Prepared By:', 0, 0, 'L');
        $this->ppdf->Cell(95, 10, 'Approved By:', 0, 1, 'L');

        $this->ppdf->Ln(1);

        $this->ppdf->SetFont('Helvetica', 'B', 10); // Use Helvetica (built-in)
        $this->ppdf->Cell(95, 0, strtoupper($buyer), 0, 0, 'L');
        $this->ppdf->Cell(95, 0, strtoupper($head), 0, 1, 'L');
        $this->ppdf->SetFont('Helvetica', '', 10); // Reset font to normal (optional)


        $this->ppdf->Line(6, $this->ppdf->GetY() + 2, 80, $this->ppdf->GetY() + 2); // Line under Prepared By
        $this->ppdf->Line(101, $this->ppdf->GetY() + 2, 175, $this->ppdf->GetY() + 2); // Line under Approved By

        $this->ppdf->Ln(2);

        $this->ppdf->Cell(95, 5, '(Signature over Printed name)', 0, 0, 'L');
        $this->ppdf->Cell(95, 5, '(Signature over Printed name)', 0, 1, 'L');

        $this->ppdf->Ln(2);

        $x = $this->ppdf->GetX() + 20; // Adjust X to start after "Date:"
        $y = $this->ppdf->GetY() + 5; // Position slightly below the text

        $this->ppdf->Cell(95, 8, 'Date:           ', 0, 0, 'L');

        $this->ppdf->Line($x, $y, $x + 35, $y);

        $x = $this->ppdf->GetX() + 20; // Adjust X to start after "Date:"
        $y = $this->ppdf->GetY() + 5; // Position slightly below the text

        $this->ppdf->Cell(95, 8, 'Date:           ', 0, 1, 'L');

        $this->ppdf->Line($x, $y, $x + 35, $y);


        addPageNumbers($this->ppdf);

        ob_clean();
        $this->ppdf->Output("{$docNo}.pdf", 'I');
        exit;
    }

    public function generatePdf($r_no = null)
    {

        // var_dump($r_no);
        // exit;
        ob_start();
        $user_details_type = $this->Acct_mod->getUserDetailsById($_SESSION["mms_user"]);

        $po_details = $this->Manual_po_mod_pdf->getPoDetailsByIdPdf($r_no);

        if (empty($po_details)) {
            // throw new Exception("No data found for PO.");
        }

        // var_dump($po_details);
        // exit;

        $header_info = $po_details[0];

        // $now = date("m/d/Y");
        // $date_now = new DateTime($now);
        $date_now = new DateTime();

        $user_details = $this->Acct_mod->getUserDetailsById($user_details_type["user_id"]);
        $emp_id = (isset($user_details)) ? $user_details["emp_id"] : "";
        $emp_details = $this->Acct_mod->retrieveEmployeeName($emp_id);
        $emp_name = (isset($emp_details)) ? $emp_details["name"] : "";
        $row["buyer_name"] = $emp_name;

        $user_details = $this->Acct_mod->getUserDetailsById($header_info["status_by"]);
        $emp_id = (isset($user_details)) ? $user_details["emp_id"] : "";
        $emp_details = $this->Acct_mod->retrieveEmployeeName($emp_id);
        $emp_name = (isset($emp_details)) ? $emp_details["name"] : "";
        $row["head_name"] = $emp_name;

        $buyer =  $row["buyer_name"];
        $head =  $row["head_name"];

        $date_generated = $date_now->format("F d, Y - h:i A");

        $file_name = $header_info["vendor_name"];

        // $store_id = $user_details_type['store_id'];

        // Define Header Fields
        $header_data = array(
            "Supplier Code"  => isset($header_info["vendor_code"]) ? $header_info["vendor_code"] : 'N/A',
            "Date Generated" => $date_generated,
            "Supplier Name"  => isset($header_info["vendor_name"]) ? $header_info["vendor_name"] : 'N/A',
        );

        // Initialize TCPDF with Letter size (8.5 x 11 inches)
        $this->ppdf = new TCPDF('L', 'mm', array(215.9, 279.4), true, 'UTF-8', false);
        $this->ppdf->SetTitle($file_name);
        $this->ppdf->SetMargins(5, 15, 5, true); // Left, Top, Right margins
        $this->ppdf->setPrintHeader(false);
        $this->ppdf->SetFont('', '', 9, '', true);
        $this->ppdf->SetAutoPageBreak(true, 1);
        $this->ppdf->AddPage();


        // Print Header (without border)
        foreach (array_chunk($header_data, 2, true) as $row) {
            foreach ($row as $label => $value) {
                $this->ppdf->SetFont('', '', 9);
                $this->ppdf->Cell(50, 6, $label . ":", 0, 0);

                $this->ppdf->SetFont('', 'B', 9);
                $this->ppdf->Cell(90, 6, $value, 0, 0);
            }
            $this->ppdf->Ln();
        }

        $this->ppdf->Ln(5);

        // Function to print table headers
        function printTableHeadersPdf($pdf)
        {
            $pdf->SetFont('', 'B', 8);
            $pdf->MultiCell(20, 4, "ITEM\nCODE", 0, 'L', 0, 0);
            $pdf->MultiCell(100, 4, "DESCRIPTION", 0, 'L', 0, 0);
            $pdf->MultiCell(20, 4, "UOM", 0, 'L', 0, 0);
            $pdf->MultiCell(30, 4, "PREVIOUS DATA", 0, 'L', 0, 0);
            $pdf->Ln();
            $pdf->Ln(5);
            $pdf->Cell(269, 0, '', 'T', 1, 'C');
        }

        // Print table headers for the first time
        printTableHeadersPdf($this->ppdf);

        // Table Data
        $this->ppdf->SetFont('', '', 8);

        function addPageNumberPdf($pdf)
        {
            $pdf->SetFont('', 'I', 7);
            $pdf->SetY(5); // Position at the bottom of the page
            $pdf->SetX(-10); // Move to the right edge
            $pdf->Cell(0, 5, 'Page ' . $pdf->getAliasNumPage() . ' of ' . $pdf->getAliasNbPages(), 0, 1, 'C');
        }

        foreach ($po_details as $item) {

            if ($this->ppdf->GetY() + 10 > $this->ppdf->getPageHeight() - 10) {
                addPageNumberPdf($this->ppdf);
                $this->ppdf->AddPage();
                printTableHeadersPdf($this->ppdf);
            }

            $this->ppdf->SetFont('', '', 8);
            $this->ppdf->Cell(20, 3, $item['item_code'], 0);
            $this->ppdf->Cell(100, 3, $item['item_desc'], 0);
            $this->ppdf->Cell(20, 3, $item['uom'], 0);
            $this->ppdf->Cell(30, 3, $item['prev_desc'], 0);

            $this->ppdf->Ln(5);
            $this->ppdf->Cell(269, 0, '', 'T', 1, 'C');
        }

        if ($this->ppdf->GetY() + 30 > $this->ppdf->getPageHeight() - 10) {
            addPageNumberPdf($this->ppdf);
            $this->ppdf->AddPage();
        }

        $this->ppdf->Cell(95, 10, 'Prepared By:', 0, 0, 'L');
        $this->ppdf->Cell(95, 10, 'Approved By:', 0, 1, 'L');

        $this->ppdf->Ln(1);

        $this->ppdf->SetFont('Helvetica', 'B', 10); // Use Helvetica (built-in)
        $this->ppdf->Cell(74, 0, strtoupper($buyer), 0, 0, 'C');
        $this->ppdf->Cell(118, 0, strtoupper($head), 0, 1, 'C');
        // $this->ppdf->Cell(95, 0, strtoupper($buyer), 0, 0, 'L');
        // $this->ppdf->Cell(95, 0, strtoupper($head), 0, 1, 'L');
        $this->ppdf->SetFont('Helvetica', '', 10); // Reset font to normal (optional)


        $this->ppdf->Line(6, $this->ppdf->GetY() + 2, 80, $this->ppdf->GetY() + 2); // Line under Prepared By
        $this->ppdf->Line(101, $this->ppdf->GetY() + 2, 175, $this->ppdf->GetY() + 2); // Line under Approved By

        $this->ppdf->Ln(2);

        $this->ppdf->Cell(95, 5, '(Signature over Printed name)', 0, 0, 'L');
        $this->ppdf->Cell(95, 5, '(Signature over Printed name)', 0, 1, 'L');

        $this->ppdf->Ln(2);

        $x = $this->ppdf->GetX() + 20; // Adjust X to start after "Date:"
        $y = $this->ppdf->GetY() + 5; // Position slightly below the text

        $this->ppdf->Cell(95, 8, 'Date:           ', 0, 0, 'L');

        $this->ppdf->Line($x, $y, $x + 35, $y);

        $x = $this->ppdf->GetX() + 20; // Adjust X to start after "Date:"
        $y = $this->ppdf->GetY() + 5; // Position slightly below the text

        $this->ppdf->Cell(95, 8, 'Date:           ', 0, 1, 'L');

        $this->ppdf->Line($x, $y, $x + 35, $y);

        addPageNumberPdf($this->ppdf);

        ob_clean();
        $this->ppdf->Output("{$file_name}.pdf", 'I');
        exit;
    }

    public function generatePdfNoSetup($r_no = null)
    {

        // var_dump($r_no);
        // exit;
        ob_start();
        $user_details_type = $this->Acct_mod->getUserDetailsById($_SESSION["mms_user"]);

        $po_details = $this->Manual_po_mod_pdf->getPoDetailsByIdPdfNoSetup($r_no);

        if (empty($po_details)) {
            // throw new Exception("No data found for PO.");
        }

        // var_dump($po_details);
        // exit;

        $header_info = $po_details[0];

        // $now = date("m/d/Y");
        // $date_now = new DateTime($now);
        $date_now = new DateTime();

        $user_details = $this->Acct_mod->getUserDetailsById($user_details_type["user_id"]);
        $emp_id = (isset($user_details)) ? $user_details["emp_id"] : "";
        $emp_details = $this->Acct_mod->retrieveEmployeeName($emp_id);
        $emp_name = (isset($emp_details)) ? $emp_details["name"] : "";
        $row["buyer_name"] = $emp_name;

        $user_details = $this->Acct_mod->getUserDetailsById($header_info["status_by"]);
        $emp_id = (isset($user_details)) ? $user_details["emp_id"] : "";
        $emp_details = $this->Acct_mod->retrieveEmployeeName($emp_id);
        $emp_name = (isset($emp_details)) ? $emp_details["name"] : "";
        $row["head_name"] = $emp_name;

        $buyer =  $row["buyer_name"];
        $head =  $row["head_name"];

        $date_generated = $date_now->format("F d, Y - h:i A");

        $file_name = $header_info["vendor_name"];

        // $store_id = $user_details_type['store_id'];

        // Define Header Fields
        $header_data = array(
            "Supplier Code"  => isset($header_info["vendor_code"]) ? $header_info["vendor_code"] : 'N/A',
            "Date Generated" => $date_generated,
            "Supplier Name"  => isset($header_info["vendor_name"]) ? $header_info["vendor_name"] : 'N/A',
        );

        // Initialize TCPDF with Letter size (8.5 x 11 inches)
        $this->ppdf = new TCPDF('L', 'mm', array(215.9, 279.4), true, 'UTF-8', false);
        $this->ppdf->SetTitle($file_name);
        $this->ppdf->SetMargins(5, 15, 5, true); // Left, Top, Right margins
        $this->ppdf->setPrintHeader(false);
        $this->ppdf->SetFont('', '', 9, '', true);
        $this->ppdf->SetAutoPageBreak(true, 1);
        $this->ppdf->AddPage();


        // Print Header (without border)
        foreach (array_chunk($header_data, 2, true) as $row) {
            foreach ($row as $label => $value) {
                $this->ppdf->SetFont('', '', 9);
                $this->ppdf->Cell(50, 6, $label . ":", 0, 0);

                $this->ppdf->SetFont('', 'B', 9);
                $this->ppdf->Cell(90, 6, $value, 0, 0);
            }
            $this->ppdf->Ln();
        }

        $this->ppdf->Ln(5);

        // Function to print table headers
        function printTableHeadersPdfNoSetup($pdf)
        {
            $pdf->SetFont('', 'B', 8);
            $pdf->MultiCell(80, 4, "STOCK\nCODE", 0, 'L', 0, 0);
            $pdf->MultiCell(150, 4, "DESCRIPTION", 0, 'L', 0, 0);
            $pdf->MultiCell(40, 4, "UOM", 0, 'L', 0, 0);
            // $pdf->MultiCell(30, 4, "PREVIOUS DATA", 0, 'L', 0, 0);
            $pdf->Ln();
            $pdf->Ln(5);
            $pdf->Cell(269, 0, '', 'T', 1, 'C');
        }

        // Print table headers for the first time
        printTableHeadersPdfNoSetup($this->ppdf);

        // Table Data
        $this->ppdf->SetFont('', '', 8);

        function addPageNumberPdfNoSetup($pdf)
        {
            $pdf->SetFont('', 'I', 7);
            $pdf->SetY(5); // Position at the bottom of the page
            $pdf->SetX(-10); // Move to the right edge
            $pdf->Cell(0, 5, 'Page ' . $pdf->getAliasNumPage() . ' of ' . $pdf->getAliasNbPages(), 0, 1, 'C');
        }

        foreach ($po_details as $item) {

            if ($this->ppdf->GetY() + 10 > $this->ppdf->getPageHeight() - 10) {
                addPageNumberPdfNoSetup($this->ppdf);
                $this->ppdf->AddPage();
                printTableHeadersPdfNoSetup($this->ppdf);
            }

            $this->ppdf->SetFont('', '', 8);
            $this->ppdf->Cell(80, 3, $item['item_code'], 0);
            $this->ppdf->Cell(150, 3, $item['item_desc'], 0);
            $this->ppdf->Cell(40, 3, $item['uom'], 0);
            // $this->ppdf->Cell(30, 3, $item['prev_desc'], 0);

            $this->ppdf->Ln(5);
            $this->ppdf->Cell(269, 0, '', 'T', 1, 'C');
        }

        if ($this->ppdf->GetY() + 30 > $this->ppdf->getPageHeight() - 10) {
            addPageNumberPdfNoSetup($this->ppdf);
            $this->ppdf->AddPage();
        }

        $this->ppdf->Cell(95, 10, 'Prepared By:', 0, 0, 'L');
        $this->ppdf->Cell(95, 10, 'Approved By:', 0, 1, 'L');

        $this->ppdf->Ln(1);

        $this->ppdf->SetFont('Helvetica', 'B', 10); // Use Helvetica (built-in)
        $this->ppdf->Cell(74, 0, strtoupper($buyer), 0, 0, 'C');
        $this->ppdf->Cell(118, 0, strtoupper($head), 0, 1, 'C');
        // $this->ppdf->Cell(95, 0, strtoupper($buyer), 0, 0, 'L');
        // $this->ppdf->Cell(95, 0, strtoupper($head), 0, 1, 'L');
        $this->ppdf->SetFont('Helvetica', '', 10); // Reset font to normal (optional)


        $this->ppdf->Line(6, $this->ppdf->GetY() + 2, 80, $this->ppdf->GetY() + 2); // Line under Prepared By
        $this->ppdf->Line(101, $this->ppdf->GetY() + 2, 175, $this->ppdf->GetY() + 2); // Line under Approved By

        $this->ppdf->Ln(2);

        $this->ppdf->Cell(95, 5, '(Signature over Printed name)', 0, 0, 'L');
        $this->ppdf->Cell(95, 5, '(Signature over Printed name)', 0, 1, 'L');

        $this->ppdf->Ln(2);

        $x = $this->ppdf->GetX() + 20; // Adjust X to start after "Date:"
        $y = $this->ppdf->GetY() + 5; // Position slightly below the text

        $this->ppdf->Cell(95, 8, 'Date:           ', 0, 0, 'L');

        $this->ppdf->Line($x, $y, $x + 35, $y);

        $x = $this->ppdf->GetX() + 20; // Adjust X to start after "Date:"
        $y = $this->ppdf->GetY() + 5; // Position slightly below the text

        $this->ppdf->Cell(95, 8, 'Date:           ', 0, 1, 'L');

        $this->ppdf->Line($x, $y, $x + 35, $y);

        addPageNumberPdfNoSetup($this->ppdf);

        ob_clean();
        $this->ppdf->Output("{$file_name}.pdf", 'I');
        exit;
    }


    public function generate_txt($r_no = null, $scode = null)
    {
        try {
            ob_end_clean();

            // var_dump($scode);
            // exit;
            $nav_main_cd_SI = isset($_POST['nav_main_cd_SI']) ? trim($_POST['nav_main_cd_SI']) : '';
            $nav_main_cd_DR = isset($_POST['nav_main_cd_DR']) ? trim($_POST['nav_main_cd_DR']) : '';

            // Fetch PO Details
            $po_details = $this->Manual_po_mod_pdf->getPoDetailsById($r_no, true);
            $po_calendar = $this->Manual_po_mod_pdf->getPoCalendar($r_no);

            $header_info = $po_details[0];

            $store_id =  isset($header_info["store_id"]) ? $header_info["store_id"] :  "";

            $store_details = $this->Manual_po_mod->get_store_details_by_id($store_id);

            $si_format = $store_details["SI_format"];
            $dr_format = $store_details["DR_format"];

            if ($store_id == 2 || $store_id == 3) {
                // var_dump($store_id);
                if ($store_id == 2) {
                    $user_store_id = '7';
                } else if ($store_id == 3) {
                    $user_store_id = '8';
                }

                $scode_details = $this->Manual_po_mod_pdf->get_scode_details($scode, $user_store_id);

                if (isset($scode_details)) {
                    if ($store_id == 2) {
                        $si_format = "ASCSOD-CPO";
                        $dr_format = "SOD-CPO";
                    } else if ($store_id == 3) {
                        $si_format = "";
                        $dr_format = "SOD";
                    }
                }
            }

            if ($store_id == 6 && $scode == 36) {

                $store_id = '36';

                $stored_details = $this->Manual_po_mod_pdf->getStoreDetails($store_id);

                $storeDetails = $stored_details[0];
            }

            if (empty($po_details)) {
                throw new Exception("No data found for PO.");
            }

            // Extract first record for header  
            // $data = $po_calendar[0];
            if (!empty($po_calendar)) {
                $data = $po_calendar[0];
            } else {
                log_message('error', "No PO calendar data found for r_no: $r_no");
                $data = []; // Set default empty array to prevent undefined offset error
            }


            $frequency = $this->Manual_po_mod_pdf->getFrequency($header_info["vendor_code"]);
            $currency_factor = 0;
            if (isset($po_calendar["currency_code"])) {
                if (strcasecmp($po_calendar["currency_code"], "php") == 0)
                    $currency_factor = 1;
            }

            $docNo_SI = "";
            $docNo_DR = "";

            $vend_types = isset($header_info['vend_type']) ? array_map('trim', explode(',', $header_info['vend_type'])) : [];

            if (in_array('SI', $vend_types)) {
                $docNo_SI = strtoupper($nav_main_cd_SI);
                if (strpos($nav_main_cd_SI, $si_format) !== 0) {

                    echo json_encode(["error" => "Invalid Document No. for SI!"]);
                    exit;
                }
            }

            if (in_array('DR', $vend_types)) {
                $docNo_DR = strtoupper($nav_main_cd_DR);
                if (strpos($nav_main_cd_DR, $dr_format) !== 0) {
                    echo json_encode(["error" => "Invalid Document No. for DR!"]);
                    exit;
                }
            }

            $base_dir = "downloads/";
            if (!is_dir($base_dir)) {
                mkdir($base_dir, 0777, true);
            }

            $si_filename = "{$base_dir}{$docNo_SI}.txt";
            $dr_filename = "{$base_dir}{$docNo_DR}.txt";

            $si_content = "";
            $dr_content = "";

            $has_si_items = false;
            $has_dr_items = false;

            $now = date("m/d/y");
            $date_now = new DateTime($now);

            // Define headers for both files
            $header_data = [
                "Order",
                "",  // 1
                isset($header_info["vendor_code"]) ? $header_info["vendor_code"] :  "",
                isset($header_info["vendor_code"]) ? $header_info["vendor_code"] :  "",
                isset($header_info["vendor_name"]) ? $header_info["vendor_name"] :  "",
                isset($header_info["vendor_name"]) ? $header_info["vendor_name"] :  "",
                isset($data["address"]) ? $data["address"] :  "",
                isset($data["address_2"]) ? $data["address_2"] :  "",
                isset($data["city"]) ? $data["city"] :  "",
                isset($data["contact"]) ? $data["contact"] :  "",
                isset($header_info["customer_name"]) ? $header_info["customer_name"] :  "", //10
                isset($header_info["customer_name"]) ? $header_info["customer_name"] :  "", //11
                isset($header_info["customer_address"]) ? $header_info["customer_address"] :  "", //12
                isset($header_info["customer_address"]) ? $header_info["customer_address"] :  "", //13
                $now,
                $now,
                "", // 16
                isset($data["payment_terms_code"]) ? $data["payment_terms_code"] :  "",
                $date_now->format("m/d/y"),
                isset($header_info["location_code"]) ? $header_info["location_code"] :  "", //19
                isset($header_info["company_code"]) ? $header_info["company_code"] :  "", //20
                isset($header_info["department_code"]) ? $header_info["department_code"] :  "", //21
                isset($data["posting_grp"]) ? $data["posting_grp"] :  "",
                isset($data["currency_code"]) ? $data["currency_code"] :  "",
                $currency_factor,
                isset($data["prices_including_vat"]) ? $data["prices_including_vat"] :  "",
                isset($data["invoice_disc_code"]) ? $data["invoice_disc_code"] :  "",
                isset($data["gen_bus_posting_group"]) ? $data["gen_bus_posting_group"] :  "",
                isset($header_info["vendor_name"]) ? $header_info["vendor_name"] :  "",
                isset($header_info["vendor_name"]) ? $header_info["vendor_name"] :  "",
                isset($data["address"]) ? $data["address"] :  "",
                isset($data["address_2"]) ? $data["address_2"] :  "",
                isset($data["city"]) ? $data["city"] :  "",
                isset($data["contact"]) ? $data["contact"] :  "",
                "G/L Account",
                "SPO-NO", //No. Series
                "SM-P-INV+", //Posting No. Series
                "SM-P-RCPT", //Receiving No. Series
                isset($data["vat_bus_posting_group"]) ? $data["vat_bus_posting_group"] :  "",
                "1", //Doc. No. Occurrence
                isset($header_info["responsibility_center"]) ? $header_info["responsibility_center"] :  "", //40
                isset($data["bus_posting_group"]) ? $data["bus_posting_group"] :  "",
                "", // Purch. Wksht. Rec. Inst.
                "", //Purch. Wksht. Source Doc.
                "Yes", //Update Item Purchase Cost
                "", //lead_time_factor
                isset($data["otdl"]) ? $data["otdl"] :  "",
                isset($data["buffer"]) ? $data["buffer"] :  "",
                isset($frequency["frequency"]) ? $frequency["frequency"] :  "",
                "", //Order Work Sheet Doc
                "0", // total amt 50
                "0", // total amt vat 51
                $date_now->format("m/d/y"), // 52
                "Receive", // 53
                "", // 54
                "1", // 55
                "", // 56
                "Open", // 57

            ];

            $total_amt_si = 0;
            $total_amt_vat_si = 0;
            $total_amt_dr = 0;
            $total_amt_vat_dr = 0;


            $si_content_lines = "";
            $dr_content_lines = "";

            $counter = 10000;

            foreach ($po_details as $item) {
                $vend_types = explode(',', $item['vend_type']);
                // $vend_types = isset($item['vend_type']) ? array_map('trim', explode(',', $item['vend_type'])) : [];
                // var_dump($vend_types);
                // exit;

                if ((in_array('SI', $vend_types) && $item['reorder_qty_SI'] == 0) ||
                    (in_array('DR', $vend_types) && $item['reorder_qty'] == 0)
                ) {
                    continue; // Skip this row
                }

                $item_code = isset($item["item_code"]) ? $item["item_code"] :  "";
                $uom = isset($item["uom"]) ? $item["uom"] :  "";
                // $variant = isset($item["variant"]) ? $item["variant"] :  "";

                $variants = isset($item["variant"]) ? $item["variant"] : "";
                $parts = explode('|', $variants);
                $variant = isset($parts[0]) ? $parts[0] : '';

                // var_dump($variant);

                $nav_price = $this->Manual_po_mod_pdf->getUnitPricesFromNav($item_code, $uom, $variant);
                $nav_prod = $this->Manual_po_mod_pdf->getItemProdFromNav($item_code);

                $vat_prod_post =  isset($nav_prod["vat_prod"]) ? $nav_prod["vat_prod"] :  "";
                $vat_bus = isset($data["vat_bus_posting_group"]) ? $data["vat_bus_posting_group"] :  "";

                $nav_vatPercent = $this->Manual_po_mod_pdf->getVatPercent($vat_prod_post, $vat_bus);
                $nav_bar = $this->Manual_po_mod_pdf->getBarcodeFromNav($item_code, $uom, $variant);
                $nav_qty_uom = $this->Manual_po_mod_pdf->getQtyUomFromNav($item_code, $uom);
                $nav_priceLCY = $this->Manual_po_mod_pdf->getUnitPriceLCY($item_code, $uom, $variant);

                $line_data = [
                    "Order",
                    "", // 1
                    $counter,
                    isset($item["vendor_code"]) ? $item["vendor_code"] :  "",
                    "Item",
                    isset($item["item_code"]) ? $item["item_code"] :  "",
                    isset($header_info["location_code"]) ? $header_info["location_code"] :  "", //6
                    isset($nav_prod["inventory_posting_grp"]) ? $nav_prod["inventory_posting_grp"] :  "",
                    $now,
                    isset($item["item_desc"]) ? $item["item_desc"] :  "",
                    isset($item["uom"]) ? $item["uom"] :  "",
                    "0", // 11 
                    "0", // Outstanding Qty 12
                    "0", // Qty to Invoice   13
                    "0", // Qty to Receive 14
                    isset($nav_price["unit_price_vat"]) ? $nav_price["unit_price_vat"] :  "",
                    isset($nav_price["unit_price"]) ? $nav_price["unit_price"] :  "",
                    $nav_vatPercent, //VAT % 
                    "0", // Amt 18 
                    "0", // Amt Vat 19
                    isset($nav_priceLCY["unit_price"]) ? $nav_priceLCY["unit_price"] :  "", // "", //Unit Price(LCY)
                    "yes",
                    isset($item["company_code"]) ? $item["company_code"] :  "", //22
                    isset($item["department_code"]) ? $item["department_code"] :  "", //23
                    "", //Indirect Cost % 
                    "0", //25
                    isset($item["vendor_code"]) ? $item["vendor_code"] :  "",
                    isset($data["gen_bus_posting_group"]) ? $data["gen_bus_posting_group"] :  "",
                    isset($nav_prod["gen_prod"]) ? $nav_prod["gen_prod"] :  "",
                    "", //transaction Type : "Normal VAT"
                    isset($data["vat_bus_posting_group"]) ? $data["vat_bus_posting_group"] :  "",
                    isset($nav_prod["vat_prod"]) ? $nav_prod["vat_prod"] :  "",
                    isset($data["currency_code"]) ? $data["currency_code"] :  "",
                    "0", // Amt Vat 33
                    "", //VAT Base Amount
                    isset($nav_price["unit_price"]) ? $nav_price["unit_price"] :  "",
                    "", //System-Created Entry
                    "0", // Amt Vat 37 
                    "", //VAT Difference
                    "", //Inv. Disc. Amount to Invoice
                    isset($nav_prod["vat_prod"]) ? $nav_prod["vat_prod"] :  "",
                    // isset($item["variant"]) ? $item["variant"] :  "",
                    $variant,
                    "", //Bin Code
                    isset($nav_qty_uom) ? $nav_qty_uom :  "",
                    isset($item["uom"]) ? $item["uom"] :  "",
                    "0", //base_qty 45 
                    "0", //base_qty 46
                    "0", //base_qty 47
                    "0", //base_qty 48
                    "", //Qty. Rcd. Not Invoiced (Base)
                    isset($header_info["responsibility_center"]) ? $header_info["responsibility_center"] :  "", //50
                    $now,
                    $now,
                    "yes",
                    isset($data["bus_posting_group"]) ? $data["bus_posting_group"] :  "",
                    isset($nav_prod["wht_prod"]) ? $nav_prod["wht_prod"] :  "",
                    "yes", // 56
                    // "0", // 
                    "no", // 57
                    "no", // 58
                    "Unlimited", // 59
                    "0D", // 60
                    $nav_bar
                ];
                $counter += 10000;

                if ($store_id === '6') {
                    $line_data[56] = "yes";
                    $line_data[57] = "no";
                    $line_data[58] = "no";
                    $line_data[59] = "no";
                    $line_data[60] = "Unlimited";
                    $line_data[61] = "0D";
                    $line_data[] = $nav_bar;
                }

                if ($scode === '36') {
                    $line_data[6] = $storeDetails['location_code'];
                    $line_data[22] = $storeDetails['company_code'];
                    $line_data[23] = $storeDetails['department_code'];
                    $line_data[50] = $storeDetails['responsibility_center'];
                }

                if (isset($scode_details)) {
                    $line_data[3] = $scode_details['sod_code'];
                    $line_data[26] = $scode_details['sod_code'];
                    $line_data[22] = $scode_details['company_code'];
                    $line_data[23] = $scode_details['department_code'];
                    $line_data[50] = $scode_details['responsibility_center'];
                }

                // If SI, add reorder_qty_SI
                if (in_array('SI', $vend_types)) {
                    $direct_unit_cost = isset($nav_price["unit_price_vat"]) ? $nav_price["unit_price_vat"] :  "";
                    $line_data[1] = $docNo_SI;
                    $line_data[11] = $item["reorder_qty_SI"];
                    $line_data[12] = $item["reorder_qty_SI"];
                    $line_data[13] = $item["reorder_qty_SI"];
                    $line_data[14] = $item["reorder_qty_SI"];
                    $line_data[25] = $item["reorder_qty_SI"] * $direct_unit_cost;
                    // $line_data[18] = $item["reorder_qty_SI"] * $nav_price["unit_price"];
                    // $line_data[19] = $item["reorder_qty_SI"] * $nav_price["unit_price_vat"];
                    $line_data[33] = $item["reorder_qty_SI"] * $nav_price["unit_price_vat"];
                    $line_data[37] = $item["reorder_qty_SI"] * $nav_price["unit_price_vat"];
                    $line_data[45] = $nav_qty_uom * $item["reorder_qty_SI"];
                    $line_data[46] = $nav_qty_uom * $item["reorder_qty_SI"];
                    $line_data[47] = $nav_qty_uom * $item["reorder_qty_SI"];
                    $line_data[48] = $nav_qty_uom * $item["reorder_qty_SI"];
                    $total_amt_si += $line_data[18];
                    $total_amt_vat_si += $line_data[19];

                    $si_content_lines .= '"' . implode('"|"', $line_data) . '"' . PHP_EOL;
                    $has_si_items = true;
                }

                // If DR, add reorder_qty
                if (in_array('DR', $vend_types)) {
                    $direct_unit_cost = isset($nav_price["unit_price_vat"]) ? $nav_price["unit_price_vat"] :  "";
                    $line_data[1] = $docNo_SI;
                    $line_data[1] = $docNo_DR;
                    $line_data[11] = $item["reorder_qty"];
                    $line_data[12] = $item["reorder_qty"];
                    $line_data[13] = $item["reorder_qty"];
                    $line_data[14] = $item["reorder_qty"];
                    $line_data[25] = $item["reorder_qty"] * $direct_unit_cost;
                    // $line_data[18] = $item["reorder_qty"] * $nav_price["unit_price"];
                    // $line_data[19] = $item["reorder_qty"] * $nav_price["unit_price_vat"];
                    $line_data[33] = $item["reorder_qty"] * $nav_price["unit_price_vat"];
                    $line_data[37] = $item["reorder_qty"] * $nav_price["unit_price_vat"];
                    $line_data[45] = $nav_qty_uom * $item["reorder_qty"];
                    $line_data[46] = $nav_qty_uom * $item["reorder_qty"];
                    $line_data[47] = $nav_qty_uom * $item["reorder_qty"];
                    $line_data[48] = $nav_qty_uom * $item["reorder_qty"];

                    $total_amt_dr += $line_data[18];
                    $total_amt_vat_dr += $line_data[19];

                    $dr_content_lines .= '"' . implode('"|"', $line_data) . '"' . PHP_EOL;
                    $has_dr_items = true;
                }
            }

            if ($store_id === '6') {
                $header_data[53] = "Receive";
                $header_data[54] = "1";
                $header_data[55] = "0";
                $header_data[56] = "Finalized";
                $header_data[57] = "Released";
            }

            if ($scode === '36') {
                $header_data[10] = $storeDetails['customer_name'];
                $header_data[11] = $storeDetails['customer_name'];
                $header_data[12] = $storeDetails['customer_address'];
                $header_data[13] = $storeDetails['customer_address'];
                $header_data[19] = $storeDetails['location_code'];
                $header_data[20] = $storeDetails['company_code'];
                $header_data[21] = $storeDetails['department_code'];
                $header_data[40] = $storeDetails['responsibility_center'];
            }

            if (isset($scode_details)) {
                $header_data[2] = $scode_details['sod_code'];
                $header_data[3] = $scode_details['sod_code'];
                $header_data[19] = $scode_details['location_code'];
                $header_data[20] = $scode_details['company_code'];
                $header_data[21] = $scode_details['department_code'];
                $header_data[40] = $scode_details['responsibility_center'];
                $header_data[54] = "1";

                if ($store_id == 2) {
                    $no_series = (in_array('SI', $vend_types)) ? "SODPO-NO" : "ACPO-NO";
                    $post_no_series = "SOD-P-INV+";
                    $rcv_no_series = "SOD-P-RCPT";

                    $header_data[35] = $no_series;
                    $header_data[36] = $post_no_series;
                    $header_data[37] = $rcv_no_series;
                    $header_data[55] = "";
                } else if ($store_id == 3) {
                    $no_series = (in_array('SI', $vend_types)) ? "" : "SOD-P-ORD";
                    $post_no_series = (in_array('SI', $vend_types)) ? "" : "SOD-P-INV+";
                    $rcv_no_series = (in_array('SI', $vend_types)) ? "" : "SOD-P-RCPT";

                    $header_data[35] = $no_series;
                    $header_data[36] = $post_no_series;
                    $header_data[37] = $rcv_no_series;
                    $header_data[55] = "";

                    // Move column values
                    $header_data[45] = $header_data[50];
                    $header_data[46] = $header_data[51];
                    $header_data[47] = $header_data[52];
                    $header_data[48] = $header_data[53];
                    $header_data[49] = $header_data[54];
                    $header_data[50] = $header_data[55];
                    $header_data[51] = $header_data[56];
                    $header_data[52] = $header_data[57];

                    array_splice($header_data, 53, 57);
                    $header_data = array_values($header_data); // User array_values to reindex

                }
            }
            // else {
            //     $header_data[2] = $scode;
            //     $header_data[3] = $scode;
            // }

            // Convert header to text format with a blank line after
            $header_data[1] = $docNo_SI;
            $header_data[16] = "Order " . $docNo_SI;
            // $header_data[50] = $total_amt_si;
            // $header_data[51] = $total_amt_vat_si;

            $si_content_header = '"' . implode('"|"', $header_data) . '"' . PHP_EOL;  // Add a blank line after header

            $si_content = $si_content_header . PHP_EOL . $si_content_lines;

            $header_data[1] = $docNo_DR;
            $header_data[16] = "Order " . $docNo_DR;
            // $header_data[50] = $total_amt_dr;
            // $header_data[51] = $total_amt_vat_dr;

            $dr_content_header = '"' . implode('"|"', $header_data) . '"' . PHP_EOL;  // Add a blank line after header

            $dr_content = $dr_content_header . PHP_EOL . $dr_content_lines;

            $response = [];

            if ($has_si_items) {
                $this->Manual_po_mod_pdf->set_docNo_SI($r_no, $docNo_SI);
                file_put_contents($si_filename, $si_content);
                $response['si_file'] = base_url($si_filename);
            }

            if ($has_dr_items) {
                $this->Manual_po_mod_pdf->set_docNo_DR($r_no, $docNo_DR);
                file_put_contents($dr_filename, $dr_content);
                $response['dr_file'] = base_url($dr_filename);
            }

            if (!$has_si_items && !$has_dr_items) {
                echo json_encode(["error" => "No valid items to generate a file."]);
                exit;
            }

            // var_dump($response);
            // exit;
            echo json_encode($response);
            exit;
        } catch (Exception $e) {
            error_log("Error generating text file: " . $e->getMessage());
            echo json_encode(["error" => "An error occurred while generating the text file."]);
            exit;
        }
    }


    public function insertNoSetup()
    {
        $user_details_type = $this->Acct_mod->getUserDetailsById($_SESSION["mms_user"]);
        $sr_user_id = '';

        if (isset($user_details_type)) {
            $sr_user_id = $user_details_type["user_id"];
        }

        $data = $this->input->POST('rows');

        // Read JSON data from request body
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);

        if (!isset($data['rows']) || empty($data['rows'])) {
            echo json_encode(["status" => "error", "message" => "No data received"]);
            return;
        }

        $firstRow = $data['rows'][0];

        // Extract values correctly without unnecessary nesting
        $id = isset($firstRow['mp_hd_id']) ? $firstRow['mp_hd_id'] : null;
        $vendor_code = isset($firstRow['vendor_code']) ? $firstRow['vendor_code'] : null;
        $vendor_name = isset($firstRow['vendor_name']) ? $firstRow['vendor_name'] : null;
        $bu = isset($firstRow['bu']) ? $firstRow['bu'] : null;
        $dept = isset($firstRow['dept']) ? $firstRow['dept'] : null;
        $reorder_date = isset($firstRow['reorder_date']) ? $firstRow['reorder_date'] : null;
        $date_generated = isset($firstRow['date_generated']) ? $firstRow['date_generated'] : null;
        $status = "pending";
        $store_id = isset($firstRow['store_id']) ? $firstRow['store_id'] : null;
        $user_id = isset($firstRow['user_id']) ? $firstRow['user_id'] : null;
        $vend_type = isset($firstRow['vend_type']) ? $firstRow['vend_type'] : null;

        if (!$vendor_code) {
            echo json_encode(["status" => "error", "message" => "Missing vendor_code"]);
            return;
        }

        $insert_data = [
            "prev_mp_hd_id" => $id,
            "vendor_code" => $vendor_code,
            "vendor_name" => $vendor_name,
            "bu" => $bu,
            "dept" => $dept,
            "reorder_date" => $reorder_date,
            "date_generated" => $date_generated,
            "status" => $status,
            "store_id" => $store_id,
            "user_id" => $user_id,
            "vend_type" => $vend_type,
            "status_by" => $sr_user_id
        ];

        // Insert into manual_po_header
        $mp_hd_id = $this->Manual_po_mod_pdf->insertManualPoHeader($insert_data);

        if ($mp_hd_id) {
            $insert_lines = []; // Initialize an empty array

            // foreach ($data['rows'] as &$row) {
            $insert_lines[] = [
                "mp_hd_id" => $mp_hd_id,
                "item_code" => isset($firstRow['item_code']) ? $firstRow['item_code'] : null,
                "item_desc" => isset($firstRow['item_desc']) ? $firstRow['item_desc'] : null,
                "uom" => isset($firstRow['uom']) ? $firstRow['uom'] : null,
                "variant" => isset($firstRow['variant']) ? $firstRow['variant'] : null,
                "qty_onhand" => isset($firstRow['qty_onhand']) ? $firstRow['qty_onhand'] : 0,
                "orig_qty_onhand" => isset($firstRow['orig_qty_onhand']) ? $firstRow['orig_qty_onhand'] : 0,
                "nav_qty_onhand" => isset($firstRow['nav_qty_onhand']) ? $firstRow['nav_qty_onhand'] : 0,
                "reorder_qty" => isset($firstRow['reorder_qty']) ? $firstRow['reorder_qty'] : 0,
                "reorder_qty_SI" => isset($firstRow['reorder_qty_SI']) ? $firstRow['reorder_qty_SI'] : 0,
                "orig_reorder_qty" => isset($firstRow['orig_reorder_qty']) ? $firstRow['orig_reorder_qty'] : 0,
                "orig_reorder_qty_SI" => isset($firstRow['orig_reorder_qty_SI']) ? $firstRow['orig_reorder_qty_SI'] : 0,
                "barcode" => isset($firstRow['barcode']) ? $firstRow['barcode'] : 0,
                "prev_desc" => isset($firstRow['prev_desc']) ? $firstRow['prev_desc'] : null,
                "data_status" => isset($firstRow['data_status']) ? $firstRow['data_status'] : null,
                "setup_status" => isset($firstRow['setup_status']) ? $firstRow['setup_status'] : null,
            ];
            // }

            // Debugging to check data before insertion
            var_dump($insert_lines);

            // Insert all rows in a batch
            $this->Manual_po_mod_pdf->insertNoSetup($insert_lines);

            // $this->Manual_po_mod_pdf->updateId($insert_lines['mp_hd_id'], $id);
            $this->Manual_po_mod_pdf->updateId($mp_hd_id, $id);


            echo json_encode(["status" => "success", "mp_hd_id" => $mp_hd_id]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to insert manual_po_header"]);
        }
        // } 
        // else {
        //     echo json_encode(["status" => "error", "message" => "No data received"]);
        // }
    }

    public function getAllData()
    {
        $mp_hd_id = $this->input->GET('mp_hd_id');
        // $setup_status = $this->input->GET('setup_status');

        $data = $this->Manual_po_mod_pdf->get_all_rows($mp_hd_id); // Fetch all rows from the database
        echo json_encode($data);
    }

    public function getAllData3()
    {
        $mp_hd_id = $this->input->GET('mp_hd_id');
        // $setup_status = $this->input->GET('setup_status');

        $data = $this->Manual_po_mod_pdf->getAll($mp_hd_id); // Fetch all rows from the database
        echo json_encode($data);
    }

    public function getAllNavData()
    {
        $mp_hd_id = $this->input->GET('mp_hd_id');
        // $setup_status = $this->input->GET('setup_status');

        $data = $this->Manual_po_mod_pdf->get_all_rows_nav($mp_hd_id); // Fetch all rows from the database
        echo json_encode($data);
    }

    public function get_data()
    {
        $user_details_type = $this->Acct_mod->getUserDetailsById($_SESSION["mms_user"]);
        $mp_hd_id = $this->input->POST('mp_hd_id');
        // $scode = $this->input->POST('scode');

        // var_dump($vendor_code);

        $po_details = $this->Manual_po_mod_pdf->getPoDetailsById($mp_hd_id);
        $po_calendar = $this->Manual_po_mod_pdf->getPoCalendar($mp_hd_id);

        $header_info = $po_details[0];
        $po_info = $po_calendar[0];

        // var_dump($po_info);
        // exit;
        $date_generated = isset($header_info["date_generated"]) ? date('F d, Y', strtotime($header_info["date_generated"])) : 'N/A';
        $docNo = 'MMSMP-' . strtoupper($header_info["value_"]) . '-' . str_pad($mp_hd_id, 7, '0', STR_PAD_LEFT);

        $user_details = $this->Acct_mod->getUserDetailsById($user_details_type["user_id"]);
        $emp_id = (isset($user_details)) ? $user_details["emp_id"] : "";
        $emp_details = $this->Acct_mod->retrieveEmployeeName($emp_id);
        $emp_name = (isset($emp_details)) ? $emp_details["name"] : "";
        $row["buyer_name"] = $emp_name;

        $user_details = $this->Acct_mod->getUserDetailsById($header_info["status_by"]);
        $emp_id = (isset($user_details)) ? $user_details["emp_id"] : "";
        $emp_details = $this->Acct_mod->retrieveEmployeeName($emp_id);
        $emp_name = (isset($emp_details)) ? $emp_details["name"] : "";
        $row["head_name"] = $emp_name;

        $store_id =  isset($header_info["store_id"]) ? $header_info["store_id"] :  "";
        $store_details = $this->Manual_po_mod->get_store_details_by_id($store_id);

        $header = $store_details["header_name"];
        $address = $store_details["address"];
        $tel = $store_details["tel"];
        $tin = $store_details["tin"];
        $buyer =  $row["buyer_name"];
        $head =  $row["head_name"];

        $data = $this->Manual_po_mod_pdf->getAllData($mp_hd_id);

        $response = [
            "store_details" => [
                "header_name" => $header,
                "address" => $address,
                "tel" => $tel,
                "tin" => $tin,
                "buyer_name" => $buyer,
                "head_name" => $head,
                "doc_no" => $docNo,
                "vend_code" => $header_info["vendor_code"],
                "vend_name" => $header_info["vendor_name"],
                "vend_address" => $po_info["address"],
                "post_date" => $date_generated,
            ],
            "data" => $data
        ];

        echo json_encode($response);
    }

    public function index()
    {

        $vendors = $this->Manual_po_mod_pdf->get_all_vendors();

        echo json_encode($vendors);
    }
}
