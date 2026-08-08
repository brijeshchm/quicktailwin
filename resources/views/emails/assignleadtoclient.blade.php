<?php
/**
 * Mail Template When New Lead Arrives.
 * Gmail / Outlook / Apple Mail / Yahoo compatible
 */
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="x-apple-disable-message-reformatting">
  <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
  <title>New Lead Alert — QuickDials</title>
 
  <style>
    /* ── RESET ── */
    body,table,td,p,a,li,blockquote{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-line-height-rule:exactly;}
    table,td{mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse!important;}
    img{-ms-interpolation-mode:bicubic;border:0;outline:none;text-decoration:none;}
    body{margin:0!important;padding:0!important;background-color:#F0F4FF;width:100%!important;min-width:100%;}

    /* ── MOBILE ── */
    @media screen and (max-width:600px){
      .email-wrap{width:100%!important;min-width:100%!important;}
      .header-td{padding:24px 20px!important;}
      .body-td{padding:24px 20px!important;}
      .lead-card{padding:20px!important;}
      .row-td{padding:10px 16px!important;}
      .logo-img{width:140px!important;}
      .co-info{display:none!important;}
      .footer-td{padding:20px!important;}
      .btn-td{padding:20px!important;}
    }

    /* ── DARK MODE ── */
    @media (prefers-color-scheme:dark){
      .dark-bg{background-color:#1a1f3a!important;}
      .dark-card{background-color:#242950!important;}
      .dark-text{color:#E5E7EB!important;}
    }
  </style>
</head>

<body style="margin:0;padding:0;background-color:#F0F4FF;font-family:Arial,Helvetica,sans-serif;">

<!-- ── PREHEADER (hidden preview text) ── -->
<div style="display:none;max-height:0;overflow:hidden;mso-hide:all;font-size:1px;line-height:1px;color:#F0F4FF;">
  🔔 New lead alert: <?php echo $lead->name; ?> is interested in <?php echo $lead->kw_text; ?> — View details inside.
  &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
</div>

<!-- ── WRAPPER ── -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#F0F4FF;">
<tr><td align="center" style="padding:30px 10px;">

  <!-- ── EMAIL CARD ── -->
  <table class="email-wrap" border="0" cellpadding="0" cellspacing="0" width="620"
         style="width:620px;max-width:620px;background-color:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 8px 40px rgba(0,93,255,.12);">

    <!-- ════ TOP ACCENT BAR ════ -->
    <tr>
      <td style="background:linear-gradient(90deg,#001F8C,#005DFF,#2D8BFF);height:5px;font-size:0;line-height:0;">&nbsp;</td>
    </tr>

    <!-- ════ HEADER ════ -->
    <tr>
      <td class="header-td" style="background:linear-gradient(135deg,#001F8C 0%,#005DFF 55%,#2D8BFF 100%);padding:32px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <!-- Logo -->
            <td width="55%" valign="middle">
              <a href="https://www.quickdials.com" target="_blank" style="text-decoration:none;">
                <img class="logo-img"
                     src="https://www.quickdials.com/client/images/quick-large-logo.png"
                     alt="QuickDials"
                     width="180"
                     style="width:180px;max-width:180px;height:auto;display:block;filter:brightness(0) invert(1);">
              </a>
            </td>
            <!-- Company Info -->
            <td class="co-info" width="45%" valign="middle" align="right"
                style="font-family:Arial,Helvetica,sans-serif;font-size:11px;color:rgba(255,255,255,.75);line-height:1.8;">
              <strong style="color:#ffffff;font-size:13px;display:block;margin-bottom:4px;">QuickDials Pvt. Ltd.</strong>
              UNIT 101 Oxford Towers, HAL Airport Rd,<br>
              faridabad — 560008, Karnataka<br>
              CIN: U63112KA2026PTC215594<br>
              TAN: BLRQ01951F
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- ════ ALERT BADGE ════ -->
    <tr>
      <td align="center" style="background:#001F8C;padding:12px 40px;">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);border-radius:20px;padding:6px 20px;">
              <span style="font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#ffffff;letter-spacing:1px;text-transform:uppercase;">
                🔔 &nbsp;New Lead Alert
              </span>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- ════ GREETING ════ -->
    <tr>
      <td class="body-td" style="padding:32px 40px 0 40px;">
        <p style="margin:0 0 8px 0;font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:700;color:#0D1340;">
          Hi <?php echo $clientname; ?>, 👋
        </p>
        <p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#4B5563;line-height:1.7;">
          Great news! You have received a new enquiry from one of our customers.
          Here are the complete lead details:
        </p>
      </td>
    </tr>

    <!-- ════ LEAD DETAILS CARD ════ -->
    <tr>
      <td class="body-td" style="padding:24px 40px;">

        <!-- Card wrapper -->
        <table class="lead-card" border="0" cellpadding="0" cellspacing="0" width="100%"
               style="background-color:#F8FAFF;border:2px solid #005DFF;border-radius:12px;overflow:hidden;">

          <!-- Card header -->
          <tr>
            <td colspan="2"
                style="background:linear-gradient(90deg,#005DFF,#2D8BFF);padding:14px 20px;">
              <span style="font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#ffffff;letter-spacing:1.5px;text-transform:uppercase;">
                📋 &nbsp;Lead Information
              </span>
            </td>
          </tr>

          <!-- Customer Name -->
          <tr style="border-bottom:1px solid #E5EAF3;">
            <td class="row-td"
                style="padding:12px 20px;width:40%;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;">
              👤 &nbsp;Customer Name
            </td>
            <td class="row-td"
                style="padding:12px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;">
              <?php echo $lead->name; ?>
            </td>
          </tr>

          <!-- Shown Interest In -->
          <tr style="border-bottom:1px solid #E5EAF3;">
            <td class="row-td"
                style="padding:12px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;">
              🔍 &nbsp;Shown Interest In
            </td>
            <td class="row-td"
                style="padding:12px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;">
              <span style="background:linear-gradient(135deg,#005DFF,#2D8BFF);color:#fff;padding:3px 12px;border-radius:12px;font-size:11.5px;font-weight:700;">
                <?php echo $lead->kw_text; ?>
              </span>
            </td>
          </tr>

          <!-- Mobile -->
          <tr style="border-bottom:1px solid #E5EAF3;">
            <td class="row-td"
                style="padding:12px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;">
              📱 &nbsp;Mobile
            </td>
            <td class="row-td"
                style="padding:12px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;">
              <a href="tel:<?php echo $lead->mobile; ?>"
                 style="color:#005DFF;text-decoration:none;">
                <?php echo $lead->mobile; ?>
              </a>
            </td>
          </tr>

          <?php if(!empty($lead->email)): ?>
          <!-- Email -->
          <tr style="border-bottom:1px solid #E5EAF3;">
            <td class="row-td"
                style="padding:12px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;">
              ✉️ &nbsp;Email ID
            </td>
            <td class="row-td"
                style="padding:12px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;">
              <a href="mailto:<?php echo $lead->email; ?>"
                 style="color:#005DFF;text-decoration:none;">
                <?php echo $lead->email; ?>
              </a>
            </td>
          </tr>
          <?php endif; ?>

          <?php if(!empty($lead->city_name)): ?>
          <!-- City -->
          <tr style="border-bottom:1px solid #E5EAF3;">
            <td class="row-td"
                style="padding:12px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;">
              📍 &nbsp;City
            </td>
            <td class="row-td"
                style="padding:12px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;">
              <?php echo $lead->city_name; ?>
            </td>
          </tr>
          <?php endif; ?>

          <?php if($lead->remark): ?>
          <!-- Remark -->
          <tr>
            <td class="row-td"
                style="padding:12px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;vertical-align:top;">
              💬 &nbsp;Remark
            </td>
            <td class="row-td"
                style="padding:12px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#374151;font-style:italic;">
              "<?php echo $lead->remark; ?>"
            </td>
          </tr>
          <?php endif; ?>

        </table>
      </td>
    </tr>

    <!-- ════ CTA BUTTON ════ -->
    <tr>
      <td class="btn-td" align="center" style="padding:0 40px 28px 40px;">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center"
                style="background:linear-gradient(135deg,#005DFF,#2D8BFF);border-radius:10px;padding:0;">
              <a href="https://www.quickdials.com" target="_blank"
                 style="display:inline-block;padding:14px 36px;font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:700;color:#ffffff;text-decoration:none;letter-spacing:.5px;">
                View Lead in Dashboard →
              </a>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- ════ QUICKDIALS CONTACT ════ -->
    <tr>
      <td style="padding:0 40px 28px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="background:#FFFBEB;border:1px solid #FDE68A;border-left:4px solid #F59E0B;border-radius:10px;">
          <tr>
            <td style="padding:16px 20px;">
              <p style="margin:0 0 10px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#92400E;letter-spacing:1px;text-transform:uppercase;">
                📞 &nbsp;QuickDials Support
              </p>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="padding:3px 0;font-family:Arial,Helvetica,sans-serif;font-size:12.5px;color:#78350F;">
                    <strong>Email:</strong>&nbsp;
                    <a href="mailto:help@quickdials.com"
                       style="color:#005DFF;text-decoration:none;font-weight:600;">
                      help@quickdials.com
                    </a>
                  </td>
                </tr>
                <tr>
                  <td style="padding:3px 0;font-family:Arial,Helvetica,sans-serif;font-size:12.5px;color:#78350F;">
                    <strong>Phone:</strong>&nbsp;
                    <a href="tel:+917559435943"
                       style="color:#005DFF;text-decoration:none;font-weight:600;">
                      +91-75-5943-5943
                    </a>
                    &nbsp;(24/7 Available)
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- ════ REGARDS ════ -->
    <tr>
      <td style="padding:0 40px 28px 40px;font-family:Arial,Helvetica,sans-serif;font-size:13.5px;color:#374151;line-height:1.8;">
        <p style="margin:0 0 4px 0;">Warm Regards,</p>
        <strong style="color:#0D1340;font-size:14px;">Team QuickDials Pvt. Ltd.</strong><br>
        <a href="https://www.quickdials.com" target="_blank"
           style="color:#005DFF;text-decoration:none;font-size:12px;">
          www.quickdials.com
        </a>
      </td>
    </tr>

    <!-- ════ NOTE ════ -->
    <tr>
      <td style="padding:0 40px 28px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="background:#F3F4F6;border-radius:8px;">
          <tr>
            <td style="padding:12px 16px;font-family:Arial,Helvetica,sans-serif;font-size:11px;color:#6B7280;line-height:1.6;">
              <strong style="color:#374151;">ℹ️ Note:</strong>
              This is a system generated email. Please do not reply to this message.
              Contact us on the details above for any queries or clarification.
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- ════ FOOTER ════ -->
    <tr>
      <td class="footer-td"
          style="background:linear-gradient(135deg,#0D1340,#1A2463);padding:24px 40px;border-radius:0 0 16px 16px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td valign="middle" style="font-family:Arial,Helvetica,sans-serif;font-size:11px;color:rgba(255,255,255,.6);line-height:1.7;">
              <strong style="color:rgba(255,255,255,.9);">Regd. Office:</strong><br>
              UNIT 101 Oxford Towers, 139/88 HAL Old Airport Rd,<br>
              H.A.L II Stage, faridabad North — 560008, Karnataka, India.
            </td>
            <td valign="middle" align="right"
                style="font-family:Arial,Helvetica,sans-serif;font-size:11px;color:rgba(255,255,255,.5);text-align:right;">
              <a href="https://www.quickdials.com/privacy-policy" target="_blank"
                 style="color:rgba(255,255,255,.6);text-decoration:none;display:block;margin-bottom:4px;">
                Privacy Policy
              </a>
             
            </td>
          </tr>
          <tr>
            <td colspan="2"
                style="padding-top:14px;font-family:Arial,Helvetica,sans-serif;font-size:10.5px;color:rgba(255,255,255,.35);border-top:1px solid rgba(255,255,255,.1);text-align:center;">
              © <?php echo date('Y'); ?> QuickDials Pvt. Ltd. All rights reserved. &nbsp;|&nbsp;
              CIN: U63112KA2026PTC215594 &nbsp;|&nbsp; TAN: BLRQ01951F
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- ── BOTTOM ACCENT ── -->
    <tr>
      <td style="background:linear-gradient(90deg,#001F8C,#005DFF,#2D8BFF);height:4px;font-size:0;line-height:0;">&nbsp;</td>
    </tr>

  </table>
  <!-- /EMAIL CARD -->

</td></tr>
</table>
<!-- /WRAPPER -->

</body>
</html>
