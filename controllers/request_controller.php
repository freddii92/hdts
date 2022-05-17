<?php
require_once("./../core/mysqli-config.php");

class ReqController {

    function __construct($conn)
    {
        $this->conn = $conn;
        $this->RefNumGen = $this->RefNumGenerator();
        $this->NextRefNum = $this->RefNumGen->current();
    }

    function getFullRequest()
    {
        $stmt = $this->conn->prepare("SELECT * FROM REQUEST_EVENT");

        $stmt->execute();

        $result = $stmt->get_result();

        $request_data = $result->fetch_assoc();

        $R_REF_NUMBER_YEAR = request_date['R_REF_NUMBER_YEAR'];

        $R_REF_NUMBER_NO = request_date['R_REF_NUMBER_NO'];

        $stmt = $this->conn->prepare("SELECT * FROM HARD_DRIVE_REQUEST WHERE BINARY R_REF_NUMBER_YEAR = ? AND BINARY R_REF_NUMBER_NO = ?");

        $stmt->bindParam("si",$R_REF_NUMBER_YEAR,$R_REF_NUMBER_NO);

        $result = $stmt->get_result();

        $hard_drive_request_data = $result->fetch_assoc();

        $data = array($request_data,$hard_drive_request_data);
        return $data;

    }




    /**
     * Generates next ref number
     */
    function RefNumGenerator()
    {

        $result = $this->conn->query("SELECT MAX(R_REF_NUMBER_NO) FROM REQUEST");

        $result = $result->fetch_assoc();

        $result = (int)$result["MAX(R_REF_NUMBER_NO)"];

        if ($result == NULL){
            $result = 0;
        }

        yield $result + 1;

    }
    /**
     * Displays the table of the given table name.
     * Parameters - table name.
     */
    function displayTable($tbl)
    {


        $sql = "SELECT * FROM " . $tbl . ";";


        if ($result = $this->conn->query($sql)) {
            echo "<h1 class='center'>" . $tbl . " data </h1>";

            echo "<table class='center' border=1 width=50%>
                <tr> ";
            $finfo = $result->fetch_fields();

            foreach ($finfo as $val) {
                echo "<th>" . $val->name . "</th>";
            }
            echo "</tr>";

            while ($row = $result->fetch_row()) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . $value . "</td>";
                }
                echo "</tr>";
            }

            echo "</table> <br><br> ";
        }
    }

    /**
     * Displays only the rows of the table found by the given value.
     * Parameters - table name, table attribute, user value.
     */
    function displaySearchBy($tbl, $attribute, $value)
    {


        $sql = "SELECT * FROM " . $tbl . " WHERE " . $attribute . "='" . $value . "';";


        if ($result = $this->conn->query($sql)) {
            echo "<h1 class='center'>" . $tbl . " data </h1>";

            echo "<table class='center' border=1 width=50%>
                <tr> ";
            $finfo = $result->fetch_fields();

            foreach ($finfo as $val) {
                echo "<th>" . $val->name . "</th>";
            }
            echo "</tr>";

            while ($row = $result->fetch_row()) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . $value . "</td>";
                }
                echo "</tr>";
            }

            echo "</table> <br><br> ";
        }
    }

    /**
     * Inserts a new row to the Request table.
     * Parameters - r_ref_number_year, r_ref_number_no, r_status, r_creation_date, r_last_modified_date, r_need_by_data, r_comments, u_username.
     */
    function insertToRequest($r_ref_number_year, $r_ref_number_no, $r_status, $r_creation_date, $r_last_modified_date, $r_need_by_data, $r_comments, $u_username)
    {


        $queryRequest = "INSERT INTO Request 
                    VALUES ('" . $r_ref_number_year . "', '" . $r_ref_number_no . "', '" . $r_status . "', '" . $r_creation_date . "', '" . $r_last_modified_date . "', '" . $r_need_by_data . "', '" . $r_comments . "', '" . $u_username . "');";

        if ($this->conn->query($queryRequest) === TRUE) {
//            echo "<br> New record created successfully for Request with Reference Number " . $r_ref_number_no;
            return true;
        } else {
//            echo "<br> The record was not created, the query: <br>" . $queryRequest . "  <br> Generated the error <br>" . $this->conn->error;
            return false;
        }
    }

    /**
     * Inserts a new row to the Hard Drive Request table.
     * Parameters - h_hard_drive_request_no, h_classification, h_amount_required, h_connection_port, h_hard_drive_size, h_hard_drive_type, h_comment, r_ref_number_year, r_ref_number_no.
     */
    function insertToHardDriveRequest($h_classification, $h_amount_required, $h_connection_port, $h_hard_drive_size, $h_hard_drive_type, $h_comment, $r_ref_number_year, $r_ref_number_no)
    {




        $queryHardDriveRequest  = "INSERT INTO hard_drive_request (h_classification, h_amount_required, h_connection_port, h_hard_drive_size, h_hard_drive_type, h_comment, r_ref_number_year, r_ref_number_no) 
                            VALUES ('$h_classification', '$h_amount_required', '$h_connection_port', '$h_hard_drive_size', '$h_hard_drive_type', '$h_comment', '$r_ref_number_year', '$r_ref_number_no');";

        if ($this->conn->query($queryHardDriveRequest) === TRUE) {
//            echo "<br> New record created successfully for Hard Drive Request with Reference Number ".$r_ref_number_no;
            return true;
        } else {
            return false;
//            echo "<br> The record was not created, the query: <br>" . $queryHardDriveRequest . "  <br> Generated the error <br>" . $this->conn->error;
        }
    }

    /**
     * Inserts a new row to the Event table.
     * Parameters - e_event_name, e_description, e_location, e_type, e_length, e_start_date, e_end_date, r_ref_number_year, r_ref_number_no.
     */
    function insertToEvent($e_event_name, $e_description, $e_location, $e_type, $e_length, $e_start_date, $e_end_date, $r_ref_number_year, $r_ref_number_no)
    {

        $queryEvent  = "INSERT INTO Event (e_event_name, e_description, e_location, e_type, e_length, e_start_date, e_end_date, r_ref_number_year, r_ref_number_no)
                    VALUES ('$e_event_name', '$e_description', '$e_location', '$e_type', '$e_length', '$e_start_date', '$e_end_date', '$r_ref_number_year', '$r_ref_number_no');";

        if ($this->conn->query($queryEvent) === TRUE) {
//            echo "<br> New record created successfully for Event with Reference Number ".$r_ref_number_no;
            return true;
        } else {
//            echo "<br> The record was not created, the query: <br>" . $queryRequest . "  <br> Generated the error <br>" . $this->conn->error;
            return false;
        }
    }

    function updateRequest($r_ref_number_year, $r_ref_number_no, $r_status, $r_creation_date, $r_last_modified_date, $r_need_by_date, $r_comments, $u_username)
    {



        $query = "UPDATE Request SET r_status='".$r_status."', r_creation_date='".$r_creation_date."', r_last_modified_date='".$r_last_modified_date."', r_need_by_date='".$r_need_by_date."', r_comments='".$r_comments."' WHERE  r_ref_number_no='".$r_ref_number_no."';";

        echo $query;



        if (mysqli_query($this->conn, $query)) {
            echo "Record updated successfully";
            header("Location: ../pages/test3.php"); // This location needs to change as more pages become available.
        } else {
            echo "Error updating record: " . mysqli_error($this->conn);
        }
    }

    function updateHardDriveRequest($h_hard_drive_request_no, $h_classification, $h_amount_required, $h_connection_port, $h_hard_drive_size, $h_hard_drive_type, $h_comment, $r_ref_number_year, $r_ref_number_no)
    {



        $query = "UPDATE Hard_drive_request SET h_classification='".$h_classification."', h_amount_required='".$h_amount_required."', h_connection_port='".$h_connection_port."', h_hard_drive_size='".$h_hard_drive_size."', h_hard_drive_type='".$h_hard_drive_type."', h_comment='".$h_comment."' WHERE  r_ref_number_no='".$r_ref_number_no."';";

        echo $query;



        if (mysqli_query($this->conn, $query)) {
            echo "Record updated successfully";
            header("Location: ../pages/test3.php"); // This location needs to change as more pages become available.
        } else {
            echo "Error updating record: " . mysqli_error($this->conn);
        }
    }

    function updateEvent($e_event_id, $e_event_name, $e_description, $e_location, $e_type, $e_length, $e_start_date, $e_end_date, $r_ref_number_year, $r_ref_number_no)
    {



        $query = "UPDATE Event SET e_event_name='".$e_event_name."', e_description='".$e_description."', e_location='".$e_location."', e_type='".$e_type."', e_length='".$e_length."', e_start_date='".$e_start_date."', e_end_date='".$e_end_date."' WHERE  r_ref_number_no='".$r_ref_number_no."';";

        echo $query;


        if (mysqli_query($this->conn, $query)) {
            echo "Record updated successfully";
            header("Location: ../pages/test3.php"); // This location needs to change as more pages become available.
        } else {
            echo "Error updating record: " . mysqli_error($this->conn);
        }
    }

    function submitRequest()
    {

    }

}

$req = new ReqController($GLOBALS['conn']);