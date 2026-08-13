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

$route['certificate']              = 'DataContext/indexMasterCert';
$route['certificate/json']         = 'DataContext/getDataCertificate';
$route['certificate/search']       = 'DataContext/getDataCertificate/search';  
$route['certificate/get-edit']     = 'DataContext/getDataEditCertificate';
$route['certificate/save']         = 'DataContext/saveDataCertificate';
$route['certificate/delete']       = 'DataContext/deleteData';

$route['city'] = 'DataContext/indexMasterCity';
$route['city/json'] = 'DataContext/getDataCity';
$route['city/get-edit'] = 'DataContext/getDataEdit';
$route['city/save'] = 'DataContext/saveDataCity';
$route['city/delete'] = 'DataContext/deleteData';

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
$route['vesselType/json'] = 'DataContext/getDataVesselType';
$route['vesselType/get-edit'] = 'DataContext/getDataEdit';
$route['vesselType/save'] = 'DataContext/saveDataVesselType';
$route['vesselType/delete'] = 'DataContext/deleteData';


$route['school'] = 'DataContext/indexMasterSchool';
$route['school/json'] = 'DataContext/getDataMasterSchool';
$route['school/get-edit'] = 'DataContext/getDataEdit';
$route['school/save'] = 'DataContext/saveDataMasterSchool';
$route['school/delete'] = 'DataContext/deleteData';


$route['openRecruitment'] = 'DataContext/openRecruitment';
$route['getOpenRecruitment'] = 'DataContext/getDataOpenRecruitment';
$route['editOpenRecruitment'] = 'DataContext/getDataEdit';
$route['saveOpenRecruitment'] = 'DataContext/saveDataOpenRecruitment';
$route['deleteOpenRecruitment'] = 'DataContext/deleteData';
$route['publishOpenRecruitment'] = 'DataContext/pubDateRecruitment';
$route['FormNewApplicant'] = 'DataContext/getFormNewApplicant';
$route['saveNewApplicant'] = 'DataContext/saveNewApplicant';
$route['getVesselType'] = 'DataContext/getVesselType';

$route['userCrew'] = 'DataContext/indexMasterCrewUser';
$route['getUserCrew'] = 'DataContext/getDataMasterCrewUser';
$route['editUserCrew'] = 'DataContext/getDataEdit';
$route['saveUserCrew'] = 'DataContext/saveDataUserMaster';
$route['deleteUserCrew'] = 'DataContext/deleteData';

$route['certMatrix'] = 'DataContext/indexCertMatrix'; 
$route['getCertMatrix'] = 'DataContext/getDataCertificateMatrix';
$route['editCertMatrix'] = 'DataContext/getDataEdit';
$route['saveCertMatrix'] = 'DataContext/saveDataCertificateMatrix';
$route['delCertMatrix'] = 'DataContext/deleteData';


$route['userSystem'] = 'DataContext/indexCrewUser';
$route['getMasterUserSystem'] = 'DataContext/getDataMasterUserSystem';
$route['editMasterUserSystem'] = 'DataContext/getDataEdit';
$route['saveMasterUserSystem'] = 'DataContext/saveDataMasterUser';
$route['deleteMasterUserSystem'] = 'DataContext/deleteData';
$route['getRolesOption'] = 'DataContext/getRolesOption';

$route['clinic'] = 'DataContext/indexMasterClinic';
$route['dataClinic'] = 'DataContext/getDataMasterClinic';
$route['saveClinic'] = 'DataContext/saveDataClinic';
$route['editClinic'] = 'DataContext/getDataEdit';
$route['deleteClinic'] = 'DataContext/deleteData';
$route['getRankOptions'] = 'DataContext/getRankByOptionArrayJson';
$route['getVesselTypeOptions'] = 'DataContext/getVesselTypeRecruitment';


$route['general'] = 'Recruitment/General/indexGeneral';
$route['generalData'] = 'Recruitment/General/getDataApplicantPositionSummaryCombined';
$route['generalTotalSubmitted'] = 'Recruitment/General/getSubmitCV';
$route['generalRankList'] = 'Recruitment/General/getRankList';
$route['DataFilter'] = 'Recruitment/General/generalDataFiltered';
$route['funnelChart'] = 'Recruitment/General/getFunnelSLA';

$route['newApplicant'] = 'Recruitment/NewApplicant/indexNewApplicant';
$route['searchDataReady'] = 'Recruitment/NewApplicant/searchDataReady';
$route['getDataNewApplicant'] = 'Recruitment/NewApplicant/getDataNewApplicent';
$route['qualifiedCrew'] = 'Recruitment/NewApplicant/setQualifiedCrew';
$route['getCertificate'] = 'Recruitment/NewApplicant/getCertificatesByPosition';
$route['getRank'] = 'DataContext/getRankByOptionArrayJson';
$route['notPosition'] = 'Recruitment/NewApplicant/setNotPositionCrew';
$route['submitNotQualified'] = 'Recruitment/NewApplicant/setNotQualifiedCrewLayer1';
$route['deleteApplicant'] = 'Recruitment/NewApplicant/deleteData';

$route['qualifyApplicant'] = 'Recruitment/QualifyApplicant/indexQualifyApplicant';
$route['searchDataQualifiedCrew'] = 'Recruitment/QualifyApplicant/searchDataQualifiedCrew';
$route['QualifiedCrewData'] = 'Recruitment/QualifyApplicant/setInterviewCrewQualify';
$route['notQualifiedCrew'] = 'Recruitment/QualifyApplicant/setNotQualifiedCrew';

$route['interviewApplicant'] = 'Recruitment/InterviewApplicant/indexInterviewApplicant';
$route['searchDataInterview'] = 'Recruitment/InterviewApplicant/searchDataInterview';
$route['passInterview'] = 'Recruitment/InterviewApplicant/passInterview';
$route['notQualifiedInterview'] = 'Recruitment/InterviewApplicant/setNotRefference';

$route['pipelineApplicant'] = 'Recruitment/PipelineApplicant/indexPipelineApplicant';
$route['searchDataPipeline'] = 'Recruitment/PipelineApplicant/searchDataPipeline';
$route['positionAvail'] = 'Recruitment/PipelineApplicant/setQualifiedCrewPipeline';
$route['qualifyPipeline'] = 'Recruitment/PipelineApplicant/setQualifiedCrewPipeline';
$route['filterPipeline'] = 'Recruitment/PipelineApplicant/getPipelineFilterOptions';


$route['mcuApplicant'] = 'Recruitment/McuApplicant/indexMcuApplicant';
$route['searchTableDataMCU'] = 'Recruitment/McuApplicant/searchDataMCUcrew';
$route['withdrawApplicant'] = 'Recruitment/McuApplicant/setWithdrawApplicant';
$route['notFitApplicant'] = 'Recruitment/McuApplicant/setNotFitApplicant';
$route['fitApplicant'] = 'Recruitment/McuApplicant/setMCUApplicant';


$route['loginCrew'] = 'CrewPortal/CrewPortal/loginCrew';
$route['logoutCrew'] = 'CrewPortal/CrewPortal/logOut';
$route['crewPortal'] = 'CrewPortal/CrewPortal/loginCrewPortal';
$route['portalCrew'] = 'CrewPortal/CrewPortal/getCrewPortal';
$route['registerCrewView'] = 'CrewPortal/CrewPortal/registerCrewView';
$route['saveRegisterCrew'] = 'CrewPortal/CrewPortal/registerCrew';
$route['personalData'] = 'CrewPortal/CrewPortal/getPersonalData';
$route['savePersonalData'] = 'CrewPortal/CrewPortal/saveDataPersonalCrew';
$route['personalDataCertificateCrew'] = 'CrewPortal/CrewPortal/getCrewDataWithCertificate';
$route['checkPersonData'] = 'CrewPortal/CrewPortal/checkPersonalData';
$route['saveCertificate'] = 'CrewPortal/CrewPortal/saveAllCertificate';
$route['crewCertificate'] = 'CrewPortal/CrewPortal/getCrewCertificatesOption';
$route['certificateDetail'] = 'CrewPortal/CrewPortal/getCertificateDetailByCertId';


//Role Access Management   
$route['roleAccess']                    = 'MenuRole/HakAkses/index';
$route['hakAkses/getRoles']             = 'MenuRole/HakAkses/getRoles';
$route['hakAkses/getRoleCodes']         = 'MenuRole/HakAkses/getRoleCodes';
$route['hakAkses/getRole']              = 'MenuRole/HakAkses/getRole';
$route['hakAkses/saveRole']             = 'MenuRole/HakAkses/saveRole';
$route['hakAkses/toggleRole']           = 'MenuRole/HakAkses/toggleRole';
$route['hakAkses/deleteRole']           = 'MenuRole/HakAkses/deleteRole';
$route['hakAkses/getPermissions']       = 'MenuRole/HakAkses/getPermissions';
$route['hakAkses/updatePermission']     = 'MenuRole/HakAkses/updatePermission';


// Crew Lifecycle Routes
$route['ActiveRoster'] = 'ActiveRoster/ActiveRoster';
$route['CrewRotation'] = 'CrewRotation/CrewRotation';
$route['MasterPersonal'] = 'MasterPersonal/MasterPersonal';
