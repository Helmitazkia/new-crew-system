<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Contract extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model("MCrewscv");
    $this->load->library("../controllers/DataContext");
    $this->load->library("session");
    $allowed_methods = array("do_login");
    $current_method = $this->router->fetch_method();
    if (
      !in_array($current_method, $allowed_methods) &&
      !$this->session->userdata("isLogin")
    ) {
      redirect("auth/login");
      exit();
    }
  }

  private function _getCompanyOptionsArray()
  {
    $rows = $this->MCrewscv->getData("kdcmp, nmcmp", "mstcmprec", "deletests = '0'", "nmcmp ASC");
    $out = array(array("value" => "", "text" => "- Select -"));
    foreach ($rows as $r) {
      $out[] = array("value" => $r->kdcmp, "text" => $r->nmcmp);
    }
    return $out;
  }

  private function _getRankOptionsArray()
  {
    $rows = $this->MCrewscv->getData("kdrank, nmrank", "mstrank", "deletests = '0' AND urutan > 0", "urutan ASC, nmrank ASC");
    $out = array(array("value" => "", "text" => "- Select -"));
    foreach ($rows as $r) {
      $out[] = array("value" => $r->kdrank, "text" => $r->nmrank);
    }
    return $out;
  }

  private function _getVesselOptionsArray()
  {
    $rows = $this->MCrewscv->getData("kdvsl, nmvsl", "mstvessel", "deletests = '0' AND st_display = 'Y'", "nmvsl ASC");
    $out = array(array("value" => "", "text" => "- Select -"));
    foreach ($rows as $r) {
      $out[] = array("value" => $r->kdvsl, "text" => $r->nmvsl);
    }
    return $out;
  }

  private function _getSignOffRemarkOptionsArray()
  {
    $rows = $this->MCrewscv->getData("kdremark, nmremark, descremark", "mstremark", "deletests = '0'", "nmremark ASC");
    $out = array(array("value" => "", "text" => "- Select -"));
    foreach ($rows as $r) {
      $label = isset($r->descremark) && $r->descremark !== '' ? "(" . $r->nmremark . ") " . $r->descremark : $r->nmremark;
      $out[] = array("value" => $r->kdremark, "text" => $label);
    }
    return $out;
  }

  public function index()
  {
    $data = array(
      "title" => "Contract",
      "optionsCompanyJson" => json_encode($this->_getCompanyOptionsArray()),
      "optionsRankJson" => json_encode($this->_getRankOptionsArray()),
      "optionsVesselJson" => json_encode($this->_getVesselOptionsArray()),
      "optionsSignOffRemarkJson" => json_encode($this->_getSignOffRemarkOptionsArray()),
    );
    $this->load->view("CrewDetail/contract", $data);
  }

  public function getAllData_contract()
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

    $sql = "SELECT A.*, B.nmcmp, C.nmrank, D.nmvsl, E.nmremark
      FROM tblcontract A
      LEFT JOIN mstcmprec B ON B.kdcmp = A.kdcmprec AND B.deletests = '0'
      LEFT JOIN mstrank C ON C.kdrank = A.signonrank AND C.deletests = '0'
      LEFT JOIN mstvessel D ON D.kdvsl = A.signonvsl AND D.deletests = '0'
      LEFT JOIN mstremark E ON E.kdremark = A.signoffremark AND E.deletests = '0'
      WHERE A.deletests = '0' AND A.idperson = ?
      ORDER BY A.signondt DESC";
    $rows = $this->db->query($sql, array($idperson))->result_array();
    $data = array();
    foreach ($rows as $row) {
      $data[] = array(
        "idcontract" => $row["idcontract"],
        "idperson" => $row["idperson"],
        "company" => isset($row["nmcmp"]) ? $row["nmcmp"] : "",
        "sign_on" => $row["signondt"],
        "sign_off" => $row["signoffdt"],
        "sign_on_rank" => isset($row["nmrank"]) ? $row["nmrank"] : "",
        "sign_on_vessel" => isset($row["nmvsl"]) ? $row["nmvsl"] : "",
        "sign_on_port" => isset($row["signonport"]) ? $row["signonport"] : "",
        "sign_on_description" => isset($row["signondesc"]) ? $row["signondesc"] : "",
        "last_vessel" => isset($row["lastvsl"]) ? $row["lastvsl"] : "",
        "estimate_sign_off" => isset($row["estsignoffdt"]) ? $row["estsignoffdt"] : "",
        "no_pkl" => isset($row["no_pkl"]) ? $row["no_pkl"] : "",
        "remark" => isset($row["estremark"]) ? $row["estremark"] : "",
        "sign_off_remark" => isset($row["nmremark"]) ? $row["nmremark"] : "",
        "file_contract" => isset($row["file_contract"]) ? $row["file_contract"] : "",
      );
    }

    $this->output->set_content_type("application/json")->set_output(
      json_encode(array(
        "success" => true,
        "data" => $data,
      ))
    );
  }

  public function get_contract_by_id()
  {
    $idcontract = $this->input->post("idcontract");
    $idperson = $this->input->post("idperson");

    $sql = "SELECT A.*, B.nmcmp, C.nmrank, D.nmvsl, E.nmremark
      FROM tblcontract A
      LEFT JOIN mstcmprec B ON B.kdcmp = A.kdcmprec AND B.deletests = '0'
      LEFT JOIN mstrank C ON C.kdrank = A.signonrank AND C.deletests = '0'
      LEFT JOIN mstvessel D ON D.kdvsl = A.signonvsl AND D.deletests = '0'
      LEFT JOIN mstremark E ON E.kdremark = A.signoffremark AND E.deletests = '0'
      WHERE A.deletests = '0' AND A.idcontract = ? AND A.idperson = ?";
    $query = $this->db->query($sql, array($idcontract, $idperson));
    $row = $query->row();

    if (!$row) {
      $this->output
        ->set_content_type("application/json")
        ->set_output(json_encode(array("success" => false, "message" => "Data not found")));
      return;
    }

    $out = array(
      "idcontract" => $row->idcontract,
      "idperson" => $row->idperson,
      "idcontractRepl" => isset($row->idcontractRepl) ? $row->idcontractRepl : "",
      "kdcmprec" => $row->kdcmprec,
      "signondt" => $row->signondt,
      "signoffdt" => $row->signoffdt,
      "estsignoffdt" => isset($row->estsignoffdt) ? $row->estsignoffdt : "",
      "signonrank" => $row->signonrank,
      "signonvsl" => $row->signonvsl,
      "signonport" => isset($row->signonport) ? $row->signonport : "",
      "signondesc" => isset($row->signondesc) ? $row->signondesc : "",
      "lastvsl" => isset($row->lastvsl) ? $row->lastvsl : "",
      "no_pkl" => isset($row->no_pkl) ? $row->no_pkl : "",
      "estremark" => isset($row->estremark) ? $row->estremark : "",
      "signoffremark" => isset($row->signoffremark) ? $row->signoffremark : "",
      "additional" => isset($row->additional) ? $row->additional : "",
      "foreigncrew" => isset($row->foreigncrew) ? $row->foreigncrew : "",
      "file_contract" => isset($row->file_contract) ? $row->file_contract : "",
    );
    $this->output->set_content_type("application/json")->set_output(json_encode($out));
  }

  public function save_contract()
  {
    $username = $this->session->userdata("userName") ?: "system";
    $currentDate = date("Ymd/H:i:s");

    $this->db->select_max("idcontract");
    $query = $this->db->get("tblcontract");
    $row = $query->row();
    $newId = $row && $row->idcontract ? (int) $row->idcontract + 1 : 1;

    $idperson = $this->input->post("idperson");
    $kdcmprec = $this->input->post("kdcmprec");
    $signondt = $this->input->post("signondt");
    $signoffdt = $this->input->post("signoffdt") ?: "0000-00-00";
    $estsignoffdt = $this->input->post("estsignoffdt") ?: "0000-00-00";
    // if ($signoffdt !== "" && $signoffdt !== "0000-00-00" && $estsignoffdt !== "" && $estsignoffdt !== "0000-00-00" && $estsignoffdt < $signoffdt) {
    //   $this->output->set_content_type("application/json")->set_output(
    //     json_encode(array("status" => false, "message" => "Estimate Sign off Date cannot be earlier than Sign off Date"))
    //   );
    //   return;
    // }
    $signonrank = $this->input->post("signonrank");
    $signonvsl = $this->input->post("signonvsl");
    $signonport = $this->input->post("signonport");
    $signondesc = $this->input->post("signondesc");
    $lastvsl = $this->input->post("lastvsl");
    $no_pkl = $this->input->post("no_pkl");
    $estremark = $this->input->post("estremark");
    $signoffremark = $this->input->post("signoffremark");
    $idcontractRepl = $this->input->post("idcontractRepl") ?: '00000';
    $foreigncrew_option = $this->input->post("foreigncrew_option");
    $additional = ($foreigncrew_option === "additional") ? 1 : 0;
    $foreigncrew = ($foreigncrew_option === "foreigncrew") ? 1 : 0;
    $file_contract = "";

    if (!empty($_FILES["file_contract"]["name"])) {
      $dataContext = new DataContext();
      $dir = FCPATH . "uploadFileContract/";
      if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
      }
      $fileName = $_FILES["file_contract"]["name"];
      $newFileName = "contract_" . $idperson . "_" . $newId . "_" . time();
      $fileUploadNya = $dataContext->uploadFile(
        $_FILES["file_contract"]["tmp_name"],
        $dir,
        $fileName,
        $newFileName
      );
      if ($fileUploadNya != "") {
        $file_contract = $fileUploadNya;
      }
    }

    $data = array(
      "idcontract" => $newId,
      "idperson" => $idperson,
      "kdcmprec" => $kdcmprec,
      "signondt" => $signondt,
      "signoffdt" => $signoffdt,
      "estsignoffdt" => $estsignoffdt,
      "signonrank" => $signonrank,
      "signonvsl" => $signonvsl,
      "signonport" => $signonport,
      "signondesc" => $signondesc,
      "lastvsl" => $lastvsl,
      "no_pkl" => $no_pkl,
      "estremark" => $estremark,
      "signoffremark" => $signoffremark,
      "idcontractRepl" => $idcontractRepl,
      "additional" => $additional,
      "foreigncrew" => $foreigncrew,
      "file_contract" => $file_contract,
      "deletests" => "0",
      "addusrdt" => $username . "/" . $currentDate,
    );

    $this->db->insert("tblcontract", $data);

    $this->output->set_content_type("application/json")->set_output(
      json_encode(array(
        "status" => true,
        "message" => "Data saved successfully",
      ))
    );
  }

  public function update_contract()
  {
    $idcontract = $this->input->post("idcontract");
    $username = $this->session->userdata("userName") ?: "system";
    $currentDate = date("Ymd/H:i:s");

    $kdcmprec = $this->input->post("kdcmprec");
    $signondt = $this->input->post("signondt");
    $signoffdt = $this->input->post("signoffdt") ?: "0000-00-00";
    $estsignoffdt = $this->input->post("estsignoffdt") ?: "0000-00-00";
    // if ($signoffdt !== "" && $signoffdt !== "0000-00-00" && $estsignoffdt !== "" && $estsignoffdt !== "0000-00-00" && $estsignoffdt < $signoffdt) {
    //   $this->output->set_content_type("application/json")->set_output(
    //     json_encode(array("status" => false, "message" => "Estimate Sign off Date cannot be earlier than Sign off Date"))
    //   );
    //   return;
    // }
    $signonrank = $this->input->post("signonrank");
    $signonvsl = $this->input->post("signonvsl");
    $signonport = $this->input->post("signonport");
    $signondesc = $this->input->post("signondesc");
    $lastvsl = $this->input->post("lastvsl");
    $no_pkl = $this->input->post("no_pkl");
    $estremark = $this->input->post("estremark");
    $signoffremark = $this->input->post("signoffremark");
    $idcontractRepl = $this->input->post("idcontractRepl") ?: '00000';
    $foreigncrew_option = $this->input->post("foreigncrew_option");
    $additional = ($foreigncrew_option === "additional") ? 1 : 0;
    $foreigncrew = ($foreigncrew_option === "foreigncrew") ? 1 : 0;

    $data = array(
      "kdcmprec" => $kdcmprec,
      "signondt" => $signondt,
      "signoffdt" => $signoffdt,
      "estsignoffdt" => $estsignoffdt,
      "signonrank" => $signonrank,
      "signonvsl" => $signonvsl,
      "signonport" => $signonport,
      "signondesc" => $signondesc,
      "lastvsl" => $lastvsl,
      "no_pkl" => $no_pkl,
      "estremark" => $estremark,
      "signoffremark" => $signoffremark,
      "idcontractRepl" => $idcontractRepl,
      "additional" => $additional,
      "foreigncrew" => $foreigncrew,
      "updusrdt" => $username . "/" . $currentDate,
    );

    if (!empty($_FILES["file_contract"]["name"])) {
      $dataContext = new DataContext();
      $dir = FCPATH . "uploadFileContract/";
      if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
      }
      $idperson = $this->input->post("idperson");
      $fileName = $_FILES["file_contract"]["name"];
      $newFileName = "contract_" . $idperson . "_" . $idcontract . "_" . time();
      $fileUploadNya = $dataContext->uploadFile(
        $_FILES["file_contract"]["tmp_name"],
        $dir,
        $fileName,
        $newFileName
      );
      if ($fileUploadNya != "") {
        $data["file_contract"] = $fileUploadNya;
      }
    }

    $this->db->where("idcontract", $idcontract);
    $this->db->update("tblcontract", $data);

    $this->output->set_content_type("application/json")->set_output(
      json_encode(array(
        "status" => true,
        "message" => "Data updated successfully",
      ))
    );
  }

  public function delete_contract()
  {
    $idcontract = $this->input->post("idcontract");
    $username = $this->session->userdata("userName") ?: "system";
    $currentDate = date("Ymd/H:i:s");

    $data = array(
      "deletests" => 1,
      "updusrdt" => $username . "/" . $currentDate,
    );

    $this->db->where("idcontract", $idcontract);
    $this->db->update("tblcontract", $data);

    $this->output->set_content_type("application/json")->set_output(
      json_encode(array(
        "status" => true,
        "message" => "Data deleted successfully",
      ))
    );
  }

  public function upload_contract_file()
  {
    $idcontract = $this->input->post("idcontract");
    $idperson = $this->input->post("idperson");

    if (empty($idcontract)) {
      $this->output
        ->set_content_type("application/json")
        ->set_output(json_encode(array("status" => false, "message" => "idcontract required")));
      return;
    }

    if (empty($_FILES["file_contract"]["name"])) {
      $this->output
        ->set_content_type("application/json")
        ->set_output(json_encode(array("status" => false, "message" => "Please select a file")));
      return;
    }

    $dataContext = new DataContext();
    $dir = FCPATH . "uploadFileContract/";
    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);
    }

    $fileName = $_FILES["file_contract"]["name"];
    $newFileName = "contract_" . $idperson . "_" . $idcontract . "_" . time();
    $fileUploadNya = $dataContext->uploadFile(
      $_FILES["file_contract"]["tmp_name"],
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

    $this->db->where("idcontract", $idcontract);
    $this->db->update("tblcontract", array(
      "file_contract" => $fileUploadNya,
      "updusrdt" => $username . "/" . $currentDate,
    ));

    $this->output->set_content_type("application/json")->set_output(
      json_encode(array(
        "status" => true,
        "message" => "File uploaded successfully",
      ))
    );
  }
}
