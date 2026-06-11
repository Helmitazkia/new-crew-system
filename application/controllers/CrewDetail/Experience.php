<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Experience extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();

        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');
        $allowed_methods = array('do_login');
        $current_method = $this->router->fetch_method();
        if (
            !in_array($current_method, $allowed_methods) &&
            !$this->session->userdata('isLogin')
        ) {
            redirect('auth/login');
            exit;
        }
    }

    
    public function index()
    {
        $dataContext = new DataContext();
        $data = array(
            'title'      => 'Active Roster',
            'optType'    => $dataContext->getVesselTypeByOption("","kode"),
            'optMstCert' => $dataContext->getMstCertificateByOption("","nama"),
            'optRank'    => $dataContext->getMstRankByOptionWithSelected("",""),
            'optCountry' => $dataContext->getCountryByOption("","kode"),
        );  
        
        $this->load->view('CrewDetail/experience',$data);
    }

    public function getAllData_experience()
    {
        $idperson = $this->input->get('idperson');

        $sql = "
            SELECT A.*, B.NmType
            FROM tblseaexp A
            LEFT JOIN tbltype B ON B.KdType = A.typeexp
            WHERE A.deletests = '0'
            AND A.idperson = ?
            ORDER BY A.fmdtexp DESC
        ";

        $rows = $this->db->query($sql, array($idperson))->result_array();

        $data = array();
        foreach ($rows as $row) {

            $data[] = array(
                'idexp'      => $row['idexp'],
                'idperson'      => $row['idperson'],
                'company'    => $row['cmpexp'],
                'flag'       => $row['flagexp'],
                'vessel'     => $row['vslexp'],
                'type'       => $row['NmType'],
                'grt'        => $row['grtexp'],
                'dwt'        => $row['dwtexp'],
                'me'         => $row['meexp'],
                'bhp'        => $row['hpexp'],
                'rank'       => $row['rankexp'],
                'date_from'  => $row['fmdtexp'] != "0000-00-00"
                                  ? date("d M Y", strtotime($row['fmdtexp']))
                                  : '',
                'date_to'    => $row['todtexp'] != "0000-00-00"
                                  ? date("d M Y", strtotime($row['todtexp']))
                                  : '',
                'foreign'    => $row['foreign_crew'],
                'reason'     => $row['reasonexp']
            );
        }

        echo json_encode(array(
            'success' => true,
            'data'    => $data
        ));
    }

    public function get_experience_by_id()
    {
        $idexp = $this->input->post('idexp');
        $idperson = $this->input->post('idperson');

        $query = $this->db->get_where('tblseaexp', array(
            'idexp'     => $idexp,
            'idperson'     => $idperson,
            'deletests' => '0'
        ));

    //    echo $this->db->last_query();exit;

        echo json_encode($query->row());
    }

    public function save_experience()
    {
            $username = $this->session->userdata('userName') ?: 'system';
            $currentDate = date('Ymd/H:i:s');

            $idperson = $this->input->post('idperson');

            // 🔹 ambil max idexp KHUSUS untuk person ini
            // Gunakan CAST agar perhitungan MAX akurat jika idexp bertipe string (misal '9' tidak dianggap lebih besar dari '10')
            $this->db->select('MAX(CAST(idexp AS UNSIGNED)) as max_id', FALSE);
            $this->db->where('idperson', $idperson);
            $query = $this->db->get('tblseaexp');
            $row = $query->row();

            $newId = ($row && $row->max_id) ? ((int)$row->max_id + 1) : 1;

            $data = array(
                'idexp'        => $newId, // 👈 tambahkan manual
                'idperson'     => $this->input->post('idperson'),
                'cmpexp'       => $this->input->post('cmpexp'),
                'vslexp'       => $this->input->post('vslexp'),
                'flagexp'      => $this->input->post('flagexp'),
                'typeexp'      => $this->input->post('typeexp'),
                'grtexp'       => $this->input->post('grtexp'),
                'dwtexp'       => $this->input->post('dwtexp'),
                'hpexp'        => $this->input->post('hpexp'),
                'meexp'        => $this->input->post('meexp'),
                'rankexp'      => $this->input->post('rankexp'),
                'fmdtexp'      => $this->input->post('fmdtexp'),
                'todtexp'      => $this->input->post('todtexp'),
                'reasonexp'    => $this->input->post('reasonexp'),
                'foreign_crew' => $this->input->post('foreign_crew'),
                'deletests'    => 0,
                'addusrdt'     => $username . '/' . $currentDate
            );

            $this->db->insert('tblseaexp', $data);

            echo json_encode(array(
                'status' => true,
                'message' => 'Data saved successfully'
            ));
    }



    public function update_experience()
    {
        $id = $this->input->post('idexp');
        $idperson = $this->input->post('idperson');
        $username = $this->session->userdata('userName') ?: 'system';
        $currentDate = date('Ymd/H:i:s');

        $data = array(
            'cmpexp'       => $this->input->post('cmpexp'),
            'vslexp'       => $this->input->post('vslexp'),
            'flagexp'      => $this->input->post('flagexp'),
            'typeexp'      => $this->input->post('typeexp'),
            'grtexp'       => $this->input->post('grtexp'),
            'dwtexp'       => $this->input->post('dwtexp'),
            'hpexp'        => $this->input->post('hpexp'),
            'meexp'        => $this->input->post('meexp'),
            'rankexp'      => $this->input->post('rankexp'),
            'fmdtexp'      => $this->input->post('fmdtexp'),
            'todtexp'      => $this->input->post('todtexp'),
            'reasonexp'    => $this->input->post('reasonexp'),
            'foreign_crew' => $this->input->post('foreign_crew'),
            'updusrdt'     => $username . '/' . $currentDate
        );

        $this->db->where('idexp', $id);
        $this->db->where('idperson', $idperson);

        $this->db->update('tblseaexp', $data);

       
        echo json_encode(array(
            'status' => true,
            'message' => 'Data updated successfully'
        ));
    }


    public function delete_experience()
    {
        $id = $this->input->post('idexp');
        $idperson = $this->input->post('idperson');
        $username = $this->session->userdata('userName') ?: 'system';
        $currentDate = date('Ymd/H:i:s');

        $data = array(
            'deletests' => 1,
            'updusrdt'  => $username . '/' . $currentDate
        );

        $this->db->where('idexp', $id);
        $this->db->where('idperson', $idperson);
        $this->db->update('tblseaexp', $data);

        echo json_encode(array(
            'status' => true,
            'message' => 'Data deleted successfully'
        ));
    }

 }
 ?>