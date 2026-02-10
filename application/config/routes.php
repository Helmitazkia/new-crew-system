<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

// $route['default_controller'] = "administrator";
// $route['default_controller'] = "front";

$route['default_controller'] = 'auth/login';
$route['404_override'] = '';

//route for master data (certificate)
$route['certificate']              = 'DataContext/indexMasterCert';
$route['certificate/json']         = 'DataContext/getDataCertificate';
$route['certificate/search']       = 'DataContext/getDataCertificate/search';  
$route['certificate/get-edit']     = 'DataContext/getDataEditCertificate';
$route['certificate/save']         = 'DataContext/saveDataCertificate';
$route['certificate/delete']       = 'DataContext/deleteData';

//route for master data (city)
$route['city'] = 'DataContext/indexMasterCity';
$route['city/json'] = 'DataContext/getDataCity';
$route['city/get-edit'] = 'DataContext/getDataEdit';
$route['city/save'] = 'DataContext/saveDataCity';
$route['city/delete'] = 'DataContext/deleteData';

//route for master data (country)
$route['country'] = 'DataContext/indexMasterCountry';
$route['country/getDataCountry'] = 'DataContext/getDataCountry';
$route['country/get-edit'] = 'DataContext/getDataEdit';
$route['country/save'] = 'DataContext/saveDataCountry';
$route['country/delete'] = 'DataContext/deleteData';



$route['company'] = 'DataContext/indexMasterCompany';
$route['company/json'] = 'DataContext/getDataCompany';
$route['company/get-edit'] = 'DataContext/getDataEdit';
$route['company/save'] = 'DataContext/saveDataCompany';
$route['company/delete'] = 'DataContext/deleteData';



$route['rank'] = 'DataContext/indexMasterRank';
$route['rank/json'] = 'DataContext/getDataRankMaster';
$route['rank/urutRank'] = 'DataContext/updateUrutRank';
$route['rank/get-edit'] = 'DataContext/getDataEdit';
$route['rank/save'] = 'DataContext/saveDataRank';
$route['rank/delete'] = 'DataContext/deleteData';



$route['vessel'] = 'DataContext/indexMasterVessel';
$route['vessel/json'] = 'DataContext/getDataVessel';
$route['vessel/get-edit'] = 'DataContext/getDataEdit';
$route['vessel/save'] = 'DataContext/saveDataVessel';
$route['vessel/delete'] = 'DataContext/deleteData';


$route['vesselType'] = 'DataContext/indexMasterVesselType';



$route['school'] = 'DataContext/indexMasterSchool';
$route['school/json'] = 'DataContext/getDataMasterSchool';
$route['school/get-edit'] = 'DataContext/getDataEdit';



/* End of file routes.php */
/* Location: ./application/config/routes.php */