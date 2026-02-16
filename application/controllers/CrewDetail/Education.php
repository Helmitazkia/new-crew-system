<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Education extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->model("MCrewscv");
    $this->load->library("../controllers/DataContext");
    $this->load->library("session");
    $allowed_methods = array("do_login");
    $current_method = $this->router->fetch_method();
    if (!in_array($current_method, $allowed_methods) && !$this->session->userdata("isLogin")) {
      redirect("auth/login");
      exit();
    }
  }

  public function index()
  {
    $dataContext = new DataContext();
    $data = array(
      "title" => "Active Roster",
      "OptYears" => $dataContext->getYearsByOption("", "kode"),
      "OptMstSchool" => $dataContext->getMstSchoolByOption("", "kode"),
    );
    $this->load->view("CrewDetail/education", $data);
  }

  public function getAllData_education()
  {
    $idperson = $this->input->get("idperson");
    if (empty($idperson)) {
      $this->output
        ->set_content_type("application/json")
        ->set_output(
          json_encode(array("success" => false, "data" => array(), "message" => "idperson required"))
        );
      return;
    }

    $sql = "
            SELECT idscl, idperson, yearscl, namescl, crsfin, scl_file
            FROM tblscl
            WHERE idperson = ?
            AND Deletests = '0'
            ORDER BY namescl ASC
        ";
    $rows = $this->db->query($sql, array($idperson))->result_array();
    $data = array();
    foreach ($rows as $row) {
      $data[] = array(
        "idscl" => $row["idscl"],
        "idperson" => $row["idperson"],
        "yearscl" => $this->_normalize_year($row["yearscl"]),
        "namescl" => $row["namescl"],
        "crsfin" => $row["crsfin"],
        "scl_file" => $row["scl_file"],
      );
    }

    $this->output->set_content_type("application/json")->set_output(
      json_encode(array(
        "success" => true,
        "data" => $data,
      ))
    );
  }

  public function get_education_by_id()
  {
    $idscl = $this->input->post("idscl");
    $idperson = $this->input->post("idperson");

    $this->db->select("*");
    $this->db->from("tblscl");
    $this->db->where(array("idscl" => $idscl, "Deletests" => "0"));
    if (!empty($idperson)) {
      $this->db->where("idperson", $idperson);
    }
    $query = $this->db->get();
    $row = $query->row();

    if (!$row) {
      $this->output
        ->set_content_type("application/json")
        ->set_output(json_encode(array("success" => false, "message" => "Data not found")));
      return;
    }

    $this->output->set_content_type("application/json")->set_output(json_encode($row));
  }

  public function save_education()
  {
    $username = $this->session->userdata("userName") ?: "system";
    $currentDate = date("Ymd/H:i:s");

    $this->db->select_max("idscl");
    $query = $this->db->get("tblscl");
    $row = $query->row();
    $newId = $row && $row->idscl ? $row->idscl + 1 : 1;

    $idperson = $this->input->post("idperson");
    $yearscl = $this->_normalize_year($this->input->post("yearscl"));
    $namescl = $this->input->post("namescl");
    $crsfin = $this->input->post("crsfin");
    $scl_file = "";

    if (!empty($_FILES["scl_file"]["name"])) {
      $dataContext = new DataContext();
      $dir = FCPATH . "uploadFile/";
      if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
      }
      $fileName = $_FILES["scl_file"]["name"];
      $newFileName = "edu_" . $idperson . "_" . $newId . "_" . time();
      $fileUploadNya = $dataContext->uploadFile(
        $_FILES["scl_file"]["tmp_name"],
        $dir,
        $fileName,
        $newFileName
      );
      if ($fileUploadNya != "") {
        $scl_file = $fileUploadNya;
      }
    }

    $data = array(
      "idscl" => $newId,
      "idperson" => $idperson,
      "yearscl" => $yearscl,
      "namescl" => $namescl,
      "crsfin" => $crsfin,
      "scl_file" => $scl_file,
      "Deletests" => "0",
      "addusrdt" => $username . "/" . $currentDate,
    );

    $this->db->insert("tblscl", $data);

    $this->output->set_content_type("application/json")->set_output(
      json_encode(array(
        "status" => true,
        "message" => "Data saved successfully",
      ))
    );
  }

  public function update_education()
  {
    $idscl = $this->input->post("idscl");
    $username = $this->session->userdata("userName") ?: "system";
    $currentDate = date("Ymd/H:i:s");

    $idperson = $this->input->post("idperson");
    $yearscl = $this->_normalize_year($this->input->post("yearscl"));
    $namescl = $this->input->post("namescl");
    $crsfin = $this->input->post("crsfin");

    $data = array(
      "yearscl" => $yearscl,
      "namescl" => $namescl,
      "crsfin" => $crsfin,
      "updusrdt" => $username . "/" . $currentDate,
    );

    if (!empty($_FILES["scl_file"]["name"])) {
      $dataContext = new DataContext();
      $dir = FCPATH . "uploadFile/";
      if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
      }
      $fileName = $_FILES["scl_file"]["name"];
      $newFileName = "edu_" . $idperson . "_" . $idscl . "_" . time();
      $fileUploadNya = $dataContext->uploadFile(
        $_FILES["scl_file"]["tmp_name"],
        $dir,
        $fileName,
        $newFileName
      );
      if ($fileUploadNya != "") {
        $data["scl_file"] = $fileUploadNya;
      }
    }

    $this->db->where("idscl", $idscl);
    $this->db->update("tblscl", $data);

    $this->output->set_content_type("application/json")->set_output(
      json_encode(array(
        "status" => true,
        "message" => "Data updated successfully",
      ))
    );
  }

  public function delete_education()
  {
    $idscl = $this->input->post("idscl");
    $username = $this->session->userdata("userName") ?: "system";
    $currentDate = date("Ymd/H:i:s");

    $data = array(
      "Deletests" => 1,
      "updusrdt" => $username . "/" . $currentDate,
    );

    $this->db->where("idscl", $idscl);
    $this->db->update("tblscl", $data);

    $this->output->set_content_type("application/json")->set_output(
      json_encode(array(
        "status" => true,
        "message" => "Data deleted successfully",
      ))
    );
  }

  public function upload_education_file()
  {
    $idscl = $this->input->post("idscl");
    $idperson = $this->input->post("idperson");

    if (empty($idscl)) {
      $this->output
        ->set_content_type("application/json")
        ->set_output(json_encode(array("status" => false, "message" => "idscl required")));
      return;
    }

    if (empty($_FILES["scl_file"]["name"])) {
      $this->output
        ->set_content_type("application/json")
        ->set_output(json_encode(array("status" => false, "message" => "Please select a file")));
      return;
    }

    $dataContext = new DataContext();
    $dir = FCPATH . "uploadFile/";
    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);
    }

    $fileName = $_FILES["scl_file"]["name"];
    $newFileName = "edu_" . $idperson . "_" . $idscl . "_" . time();
    $fileUploadNya = $dataContext->uploadFile(
      $_FILES["scl_file"]["tmp_name"],
      $dir,
      $fileName,
      $newFileName
    );

    if ($fileUploadNya == "") {
      $this->output
        ->set_content_type("application/json")
        ->set_output(json_encode(array("status" => false, "message" => "Upload failed")));
      return;
    }

    $username = $this->session->userdata("userName") ?: "system";
    $currentDate = date("Ymd/H:i:s");

    $this->db->where("idscl", $idscl);
    $this->db->update("tblscl", array(
      "scl_file" => $fileUploadNya,
      "updusrdt" => $username . "/" + $currentDate,
    ));

    $this->output->set_content_type("application/json")->set_output(
      json_encode(array(
        "status" => true,
        "message" => "File uploaded successfully",
      ))
    );
  }

  private function _normalize_year($year)
  {
    if ($year === null || $year === "") {
      return "";
    }
    $digits = preg_replace("/\D/", "", (string) $year);
    return substr($digits, 0, 4);
  }
}