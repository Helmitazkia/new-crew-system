<!DOCTYPE html>
<html>

<head>
  <title>Briefing Checklist Form</title>
  <style>
    body {
      font-family: 'Times New Roman', serif;
      font-size: 11px;
    }

    .text-center {
      text-align: center;
    }

    .fw-bold {
      font-weight: bold;
    }

    .w-100 {
      width: 100%;
    }

    .header-title {
      font-size: 14px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 10px;
    }

    .table-noborder {
      width: 100%;
      border-collapse: collapse;
    }

    .table-noborder td {
      padding: 2px;
      vertical-align: top;
    }

    .section-header {
      font-weight: bold;
      text-decoration: underline;
      margin-bottom: 5px;
    }

    .box-tick {
      display: inline-block;
      width: 12px;
      height: 12px;
      border: 1px solid #000;
      text-align: center;
      line-height: 12px;
      font-size: 10px;
      font-family: 'DejaVu Sans', sans-serif;
      margin-right: 5px;
    }
  </style>
</head>

<body>

  <table class="table-noborder" style="margin-bottom:10px;">
    <tr>
      <td style="width: 30%;" border="1">
        <img src="./assets/img/andhika.jpg" alt="Logo Andhika" style="max-width:60px; height: auto;">
        <!-- <img src="<?= base_url('assets/img/Adnyana.bmp') ?>" alt="Logo Andhika" style="max-width: 150px; height: auto;"> -->
      </td>
      <td width="25%" align="right" valign="middle">
        <div style="font-size:11px; font-weight:bold;">
          SRPS LICENSE NO:                 
        </div>
        <div style="font-size:10px;">
         SIUKAK 236.121-R Tahun  2025 
        </div>
        <div>
          <img src="./assets/img/Bureau_Veritas_Logo.jpg" style="height:30px;">
          <img src="./assets/img/Iso.jpg" style="height:30px;">
        </div>
      </td>

    </tr>
  </table>

  <div style="margin-bottom: 15px;">
    <span class="box-tick">&#10003;</span> Please tick the column during briefing / test
  </div>
  <div style="margin-bottom: 2px;">
    <div style="font-weight:bold; font-size: 15px;">
      BRIEFING CHECK LIST PRIOR JOINING VESSEL
    </div>
  </div>

  <?php
    function renderTick($val) {
        if ($val === '1' || $val === 1) return '&#10003;';
        if ($val === '0' || $val === 0) return '&#10007;';
        return '&nbsp;';
    }

    $checklist_items = array();
    if (!empty($history->checklist_data)) {
        $checklist_items = explode(',', $history->checklist_data);
    }
    
    // Helper to get tick box HTML
    function getBox($index, $checklist_items) {
        $val = isset($checklist_items[$index-1]) ? $checklist_items[$index-1] : '';
        return '<span class="box-tick">'.renderTick($val).'</span>';
    }
    ?>

  <table class="table-noborder" style="width: 100%;margin-top: 10px;">
    <tr>
      <!-- LEFT COLUMN -->
      <td style="width: 50%; padding-right: 15px; margin-top: 10px;">

        <div class="section-header">ABOUT AES</div>
        <table class="table-noborder">
          <tr>
            <td style="width:65%;"><?php echo getBox(1, $checklist_items); ?> Crew Manning Agent</td>
            <td style="width:35%;">Well understood by,</td>
          </tr>
          <tr>
            <td><?php echo getBox(2, $checklist_items); ?> Company Policy</td>
            <td style="border-bottom: 1px solid #000;"></td>
          </tr>
          <tr>
            <td><?php echo getBox(3, $checklist_items); ?> Organization</td>
            <td>Date :
              <?php echo !empty($history->date_briefing) ? date('d-M-Y', strtotime($history->date_briefing)) : '............'; ?>
            </td>
          </tr>
        </table>

        <br>
        <div class="section-header">ABOUT PRINCIPALS</div>
        <table class="table-noborder">
          <tr>
            <td style="width:65%;"><?php echo getBox(14, $checklist_items); ?> Organisation</td>
            <td style="width:32%;">Well understood by,</td>
          </tr>
          <tr>
            <td><?php echo getBox(15, $checklist_items); ?> Q M System</td>
            <td style="border-bottom: 1px solid #000;"></td>
          </tr>
          <tr>
            <td></td>
            <td>Date :
              <?php echo !empty($history->date_briefing) ? date('d-M-Y', strtotime($history->date_briefing)) : '............'; ?>
            </td>
          </tr>
        </table>

        <br>
        <div class="section-header">EMPLOYMENT CONTRACT</div>
        <table class="table-noborder">
          <tr>
            <td style="width:65%;"><?php echo getBox(16, $checklist_items); ?> Service Period</td>
            <td style="width:35%;">Well understood by,</td>
          </tr>
          <tr>
            <td><?php echo getBox(17, $checklist_items); ?> Vessel's route</td>
            <td style="border-bottom: 1px solid #000;"></td>
          </tr>
          <tr>
            <td><?php echo getBox(18, $checklist_items); ?> Type of vessel</td>
            <td>Date :
              <?php echo !empty($history->date_briefing) ? date('d-M-Y', strtotime($history->date_briefing)) : '............'; ?>
            </td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(19, $checklist_items); ?> Insurance</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(20, $checklist_items); ?> Collective Bargaining Agreement</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(21, $checklist_items); ?> MLC and Indonesia Goverment Regulation no. 7 -
              2000</td>
          </tr>
        </table>

        <br>
        <div class="section-header">SALARY</div>
        <table class="table-noborder">
          <tr>
            <td style="width:65%;"><?php echo getBox(26, $checklist_items); ?> As per contract</td>
            <td style="width:35%;">Well understood by,</td>
          </tr>
          <tr>
            <td><?php echo getBox(27, $checklist_items); ?> Bank Account</td>
            <td style="border-bottom: 1px solid #000;"></td>
          </tr>
          <tr>
            <td><?php echo getBox(28, $checklist_items); ?> Onboard / Home Salary</td>
            <td>Date :
              <?php echo !empty($history->date_briefing) ? date('d-M-Y', strtotime($history->date_briefing)) : '............'; ?>
            </td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(29, $checklist_items); ?> NPWP</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(30, $checklist_items); ?> Deduction (if any)</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(31, $checklist_items); ?> Exchange rates - company</td>
          </tr>
        </table>

        <br>
        <div class="section-header">HEALTH SAFETY N ENVIRONMENT</div>
        <table class="table-noborder">
          <tr>
            <td style="width:65%;"><?php echo getBox(40, $checklist_items); ?> Health</td>
            <td style="width:35%;">Well understood by,</td>
          </tr>
          <tr>
            <td><?php echo getBox(41, $checklist_items); ?> Safety</td>
            <td style="border-bottom: 1px solid #000;"></td>
          </tr>
          <tr>
            <td><?php echo getBox(42, $checklist_items); ?> Environment Protection</td>
            <td>Date :
              <?php echo !empty($history->date_briefing) ? date('d-M-Y', strtotime($history->date_briefing)) : '............'; ?>
            </td>
          </tr>
        </table>

        <br>
        <div class="section-header">IN HOUSE TRAINING</div>
        <table class="table-noborder">
          <tr>
            <td style="width:65%;"><?php echo getBox(43, $checklist_items); ?> English</td>
            <td style="width:35%;">Well understood by,</td>
          </tr>
          <tr>
            <td><?php echo getBox(44, $checklist_items); ?> ISM Code/Safety</td>
            <td style="border-bottom: 1px solid #000;"></td>
          </tr>
          <tr>
            <td><?php echo getBox(45, $checklist_items); ?> Risk Management</td>
            <td>Date :
              <?php echo !empty($history->date_briefing) ? date('d-M-Y', strtotime($history->date_briefing)) : '............'; ?>
            </td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(46, $checklist_items); ?> Deck or Engine Knowledge</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(47, $checklist_items); ?> Operating Procedur Manual</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(48, $checklist_items); ?> Others</td>
          </tr>
        </table>

      </td>

      <!-- RIGHT COLUMN -->
      <td style="width: 50%; padding-left: 15px;">

        <div class="section-header">DISCIPLINE & COMPLAIN</div>
        <table class="table-noborder">
          <tr>
            <td style="width:65%;"><?php echo getBox(4, $checklist_items); ?> Personal Protective Equipment</td>
            <td style="width:35%;">Well understood by,</td>
          </tr>
          <tr>
            <td><?php echo getBox(5, $checklist_items); ?> Complaints/Problems onboard</td>
            <td style="border-bottom: 1px solid #000;"></td>
          </tr>
          <tr>
            <td style="padding-left:15px;">(received Complaint Proc. & Form)</td>
            <td>Date :
              <?php echo !empty($history->date_briefing) ? date('d-M-Y', strtotime($history->date_briefing)) : '............'; ?>
            </td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(6, $checklist_items); ?> Disciplinary Procedure</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(7, $checklist_items); ?> Drug and Alcohol Policy</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(8, $checklist_items); ?> Anti Smuggling</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(9, $checklist_items); ?> Jump Ship</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(10, $checklist_items); ?> Pornography prohibition</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(11, $checklist_items); ?> Borrow money on board</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(12, $checklist_items); ?> Online gambling</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(13, $checklist_items); ?> Online Loan</td>
          </tr>
        </table>

        <br>
        <div class="section-header">MEDICAL</div>
        <table class="table-noborder">
          <tr>
            <td style="width:65%;"><?php echo getBox(22, $checklist_items); ?> Pre-employment medical check up</td>
            <td style="width:35%;">Well understood by,</td>
          </tr>
          <tr>
            <td><?php echo getBox(23, $checklist_items); ?> Drug and Alcohol test/Screening</td>
            <td style="border-bottom: 1px solid #000;"></td>
          </tr>
          <tr>
            <td><?php echo getBox(24, $checklist_items); ?> Crew Medical coverage</td>
            <td>Date :
              <?php echo !empty($history->date_briefing) ? date('d-M-Y', strtotime($history->date_briefing)) : '............'; ?>
            </td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(25, $checklist_items); ?> Sick onboard / medical report</td>
          </tr>
        </table>

        <br>
        <div class="section-header">LATEST INCIDENCES</div>
        <table class="table-noborder">
          <tr>
            <td style="width:65%;"><?php echo getBox(32, $checklist_items); ?> Crew Incident</td>
            <td style="width:35%;">Well understood by,</td>
          </tr>
          <tr>
            <td><?php echo getBox(33, $checklist_items); ?> Fire / Piracy</td>
            <td style="border-bottom: 1px solid #000;"></td>
          </tr>
          <tr>
            <td><?php echo getBox(34, $checklist_items); ?> Engine problem</td>
            <td>Date :
              <?php echo !empty($history->date_briefing) ? date('d-M-Y', strtotime($history->date_briefing)) : '............'; ?>
            </td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(35, $checklist_items); ?> Other Emergency situations</td>
          </tr>
        </table>

        <br>
        <div class="section-header">TRAVEL TO JOIN VESSEL</div>
        <table class="table-noborder">
          <tr>
            <td style="width:65%;"><?php echo getBox(36, $checklist_items); ?> Agents Address</td>
            <td style="width:35%;">Well understood by,</td>
          </tr>
          <tr>
            <td><?php echo getBox(37, $checklist_items); ?> Emergency contact</td>
            <td style="border-bottom: 1px solid #000;"></td>
          </tr>
          <tr>
            <td><?php echo getBox(38, $checklist_items); ?> Schedule of join (Date & Time)</td>
            <td>Date :
              <?php echo !empty($history->date_briefing) ? date('d-M-Y', strtotime($history->date_briefing)) : '............'; ?>
            </td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(39, $checklist_items); ?> Airport rules</td>
          </tr>
        </table>

        <br>
        <div class="section-header">LEAVE / DOCUMENTS</div>
        <table class="table-noborder">
          <tr>
            <td style="width:65%;"><?php echo getBox(49, $checklist_items); ?> Reporting system</td>
            <td style="width:35%;">Well understood by,</td>
          </tr>
          <tr>
            <td><?php echo getBox(50, $checklist_items); ?> On leave surrender documents</td>
            <td style="border-bottom: 1px solid #000;"></td>
          </tr>
          <tr>
            <td><?php echo getBox(51, $checklist_items); ?> Validity of documents</td>
            <td>Date :
              <?php echo !empty($history->date_briefing) ? date('d-M-Y', strtotime($history->date_briefing)) : '............'; ?>
            </td>
          </tr>
          <tr>
            <td colspan="2"><?php echo getBox(52, $checklist_items); ?> Present address</td>
          </tr>
        </table>

        <br>
        <div class="section-header">WORKING HOURS</div>
        <table class="table-noborder">
          <tr>
            <td style="width:65%;"><?php echo getBox(53, $checklist_items); ?> Working Hours (Max. 72 hours in<br>any 7
              days or max. 14 hrs/day)</td>
            <td style="width:35%;">Well understood by,</td>
          </tr>
          <tr>
            <td><?php echo getBox(54, $checklist_items); ?> Rest Periods (Min. 77 hours in<br>any 7 days or min. 10
              hrs/day)</td>
            <td style="border-bottom: 1px solid #000;"></td>
          </tr>
          <tr>
            <td></td>
            <td>Date :
              <?php echo !empty($history->date_briefing) ? date('d-M-Y', strtotime($history->date_briefing)) : '............'; ?>
            </td>
          </tr>
        </table>

      </td>
    </tr>
  </table>

  <div style="padding: 15px; margin-top: 30px;">
    I (Rank, Name & Signature)
    <span style="border-bottom: 1px solid #000; display: inline-block; width: 600px; text-align:center;">
      <?php echo htmlspecialchars($history->rank . ' - ' . $history->nama_crew); 
      if (!empty($history->signature_qr)) {
          echo '<br><img src="./assets/imgQRCodeCrewCV/' . $history->signature_qr . '" alt="Signature" style="height:40px;">';
      }
      ?>
    </span>
    <br>  
    <span style="text-align:center;">was carried out and briefed </span><br><br>
    on the above by Mr/Ms
    <span style="border-bottom: 1px solid #000; display: inline-block; width: 300px; text-align:center;">
      <?php echo htmlspecialchars($history->mr_ms_by); ?>
    </span>
    date
    <span style="border-bottom: 1px solid #000; display: inline-block; width: 200px; text-align:center;">
      <?php echo !empty($history->date_briefing) ? date('d F Y', strtotime($history->date_briefing)) : ''; ?>
    </span> <br><br>
    prior joining vessel MV/MT
    <span style="border-bottom: 1px solid #000; display: inline-block; width: 500px; text-align:center;">
      <?php echo htmlspecialchars($history->prior_joining_vessel); ?>
    </span>
  </div>

</body>

</html>