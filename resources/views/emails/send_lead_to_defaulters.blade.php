<?php
/**
 * Mail Template — New Lead Notification (with masked contact)
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
  <!--[if mso]>
  <noscript>
    <xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml>
  </noscript>
  <![endif]-->
  <style>
    body,table,td,p,a,li{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-line-height-rule:exactly;}
    table,td{mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse!important;}
    img{-ms-interpolation-mode:bicubic;border:0;outline:none;text-decoration:none;display:block;}
    body{margin:0!important;padding:0!important;background-color:#F0F4FF;width:100%!important;}

    @media screen and (max-width:600px){
      .email-wrap{width:100%!important;min-width:100%!important;}
      .header-td{padding:24px 20px!important;}
      .body-td{padding:20px!important;}
      .footer-td{padding:20px!important;}
      .hide-mob{display:none!important;}
      .stat-td{padding:12px 8px!important;}
      .stat-num{font-size:20px!important;}
    }

    @media (prefers-color-scheme:dark){
      .dark-bg{background-color:#1a1f3a!important;}
      .dark-card{background-color:#242950!important;}
    }
  </style>
</head>

<body style="margin:0;padding:0;background-color:#F0F4FF;font-family:Arial,Helvetica,sans-serif;">

<!-- Preheader -->
<div style="display:none;max-height:0;overflow:hidden;mso-hide:all;font-size:1px;color:#F0F4FF;">
  🔔 New lead: <?php echo $lead->name; ?> is interested in <?php echo $lead->kw_text; ?> — Upgrade to see full contact details!
  &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
</div>

<!-- WRAPPER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#F0F4FF;">
<tr><td align="center" style="padding:30px 10px;">

  <!-- EMAIL CARD -->
  <table class="email-wrap" border="0" cellpadding="0" cellspacing="0" width="620"
         style="width:620px;max-width:620px;background-color:#ffffff;border-radius:18px;overflow:hidden;box-shadow:0 8px 40px rgba(0,93,255,.13);">

    <!-- TOP ACCENT — Blue + Orange -->
    <tr>
      <td style="font-size:0;line-height:0;height:5px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td style="background:#005DFF;height:5px;width:25%;font-size:0;">&nbsp;</td>
            <td style="background:#FB641B;height:5px;width:25%;font-size:0;">&nbsp;</td>
            <td style="background:#005DFF;height:5px;width:25%;font-size:0;">&nbsp;</td>
            <td style="background:#FB641B;height:5px;width:25%;font-size:0;">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- HEADER -->
    <tr>
      <td class="header-td"
          style="background:linear-gradient(135deg,#001F8C 0%,#005DFF 55%,#2D8BFF 100%);padding:32px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td width="55%" valign="middle">
              <a href="https://www.quickdials.com" target="_blank" style="text-decoration:none;">
                <img src="https://quickdials.com/client/images/quick-large-logo.png"
                     alt="QuickDials" width="170"
                     style="width:170px;max-width:170px;height:auto;filter:brightness(0) invert(1);">
              </a>
            </td>
            <td class="hide-mob" width="45%" valign="middle" align="right"
                style="font-family:Arial,Helvetica,sans-serif;font-size:11px;color:rgba(255,255,255,.75);line-height:1.85;text-align:right;">
              <strong style="color:#fff;font-size:13px;display:block;margin-bottom:3px;">QuickDials Pvt. Ltd.</strong>
              Bengaluru, Karnataka, India<br>
              care@quickdials.com<br>
              +91-75-5943-5943
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- STATS BAR -->
    <tr>
      <td style="background:#001F8C;padding:0;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td class="stat-td" width="33%" align="center"
                style="padding:13px 12px;border-right:1px solid rgba(255,255,255,.1);">
              <div class="stat-num"
                   style="font-family:Arial,Helvetica,sans-serif;font-size:22px;font-weight:800;color:#FB641B;line-height:1;">
                10,000+
              </div>
              <div style="font-family:Arial,Helvetica,sans-serif;font-size:10px;color:rgba(255,255,255,.6);margin-top:3px;text-transform:uppercase;letter-spacing:.5px;">
                Institutes Served
              </div>
            </td>
            <td class="stat-td" width="33%" align="center"
                style="padding:13px 12px;border-right:1px solid rgba(255,255,255,.1);">
              <div class="stat-num"
                   style="font-family:Arial,Helvetica,sans-serif;font-size:22px;font-weight:800;color:#FB641B;line-height:1;">
                50,000+
              </div>
              <div style="font-family:Arial,Helvetica,sans-serif;font-size:10px;color:rgba(255,255,255,.6);margin-top:3px;text-transform:uppercase;letter-spacing:.5px;">
                Leads Generated
              </div>
            </td>
            <td class="stat-td" width="33%" align="center" style="padding:13px 12px;">
              <div class="stat-num"
                   style="font-family:Arial,Helvetica,sans-serif;font-size:22px;font-weight:800;color:#FB641B;line-height:1;">
                100+
              </div>
              <div style="font-family:Arial,Helvetica,sans-serif;font-size:10px;color:rgba(255,255,255,.6);margin-top:3px;text-transform:uppercase;letter-spacing:.5px;">
                Cities Covered
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- LEAD ALERT BADGE -->
    <tr>
      <td align="center" style="padding:28px 40px 0 40px;">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td style="background:#FFF7ED;border:1px solid #FED7AA;border-radius:20px;padding:7px 22px;">
              <span style="font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#C2410C;letter-spacing:1px;text-transform:uppercase;">
                🔔 &nbsp;New Lead Received
              </span>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- GREETING -->
    <tr>
      <td class="body-td" style="padding:18px 40px 8px 40px;">
        <h1 style="margin:0 0 8px 0;font-family:Arial,Helvetica,sans-serif;font-size:19px;font-weight:800;color:#0D1340;line-height:1.3;">
          Hi <?php echo $client->business_name; ?>! 👋
        </h1>
        <p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#4B5563;line-height:1.75;">
          You have received a new enquiry from one of our customers.
          Here are the lead details:
        </p>
      </td>
    </tr>

    <!-- LEAD DETAILS CARD -->
    <tr>
      <td class="body-td" style="padding:14px 40px 8px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="background:#F8FAFF;border:2px solid #005DFF;border-radius:12px;overflow:hidden;">

          <!-- Card Header -->
          <tr>
            <td colspan="2"
                style="background:linear-gradient(90deg,#005DFF,#2D8BFF);padding:13px 20px;">
              <span style="font-family:Arial,Helvetica,sans-serif;font-size:11.5px;font-weight:700;color:#fff;letter-spacing:1.5px;text-transform:uppercase;">
                👤 &nbsp;Lead Information
              </span>
            </td>
          </tr>

          <!-- Customer Name -->
          <tr>
            <td style="padding:11px 20px;width:38%;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;border-bottom:1px solid #E5EAF3;">
              👤 &nbsp;Customer Name
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:700;color:#0D1340;border-bottom:1px solid #E5EAF3;">
              <?php echo $lead->name; ?>
            </td>
          </tr>

          <!-- Shown Interest In -->
          <tr>
            <td style="padding:11px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;border-bottom:1px solid #E5EAF3;">
              🔍 &nbsp;Shown Interest In
            </td>
            <td style="padding:11px 20px;border-bottom:1px solid #E5EAF3;">
              <span style="background:linear-gradient(135deg,#005DFF,#2D8BFF);color:#fff;padding:3px 12px;border-radius:12px;font-size:11.5px;font-weight:700;font-family:Arial,Helvetica,sans-serif;">
                <?php echo $lead->kw_text; ?>
              </span>
            </td>
          </tr>

          <!-- City -->
          <tr>
            <td style="padding:11px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;border-bottom:1px solid #E5EAF3;">
              🏙️ &nbsp;City
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;border-bottom:1px solid #E5EAF3;">
              <?php echo $lead->city; ?>
            </td>
          </tr>

          <!-- Area -->
          <tr>
            <td style="padding:11px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;border-bottom:1px solid #E5EAF3;">
              📍 &nbsp;Area
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;border-bottom:1px solid #E5EAF3;">
              <?php echo $lead->area; ?>
            </td>
          </tr>

          <!-- Email (masked) -->
          <tr>
            <td style="padding:11px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;border-bottom:1px solid #E5EAF3;">
              ✉️ &nbsp;Email ID
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#6B7280;border-bottom:1px solid #E5EAF3;">
              <span style="letter-spacing:1px;"><?php echo getStarCodedStr($lead->email,'email'); ?></span>
              &nbsp;
              <span style="background:#FEF2F2;color:#DC2626;border:1px solid #FECACA;padding:2px 8px;border-radius:8px;font-size:10.5px;font-weight:700;font-family:Arial,Helvetica,sans-serif;">
                🔒 Masked
              </span>
            </td>
          </tr>

          <!-- Mobile (masked) -->
          <tr>
            <td style="padding:11px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;<?php echo $lead->remark ? 'border-bottom:1px solid #E5EAF3;' : ''; ?>">
              📱 &nbsp;Mobile
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#6B7280;<?php echo $lead->remark ? 'border-bottom:1px solid #E5EAF3;' : ''; ?>">
              <span style="letter-spacing:1px;"><?php echo getStarCodedStr($lead->mobile,'number'); ?></span>
              &nbsp;
              <span style="background:#FEF2F2;color:#DC2626;border:1px solid #FECACA;padding:2px 8px;border-radius:8px;font-size:10.5px;font-weight:700;font-family:Arial,Helvetica,sans-serif;">
                🔒 Masked
              </span>
            </td>
          </tr>

          <?php if($lead->remark): ?>
          <!-- Remark -->
          <tr>
            <td style="padding:11px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;vertical-align:top;">
              💬 &nbsp;Remark
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#374151;font-style:italic;">
              "<?php echo $lead->remark; ?>"
            </td>
          </tr>
          <?php endif; ?>

        </table>
      </td>
    </tr>

    <!-- UPGRADE CTA -->
    <tr>
      <td class="body-td" style="padding:14px 40px 8px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="background:linear-gradient(135deg,#FFF7ED,#FEF3C7);border:2px solid #FB641B;border-radius:12px;overflow:hidden;">
          <tr>
            <td style="padding:20px 24px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td valign="middle">
                    <p style="margin:0 0 6px 0;font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:800;color:#C2410C;">
                      🔓 Unlock Full Contact Details
                    </p>
                    <p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:12.5px;color:#92400E;line-height:1.6;">
                      Upgrade to a <strong>paid account</strong> to access complete mobile numbers, email addresses, and priority lead alerts.
                    </p>
                  </td>
                  <td valign="middle" align="right" style="padding-left:16px;white-space:nowrap;">
                    <table border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td style="background:linear-gradient(135deg,#FB641B,#FF8C42);border-radius:8px;">
                          <a href="https://www.quickdials.com/pricing" target="_blank"
                             style="display:inline-block;padding:11px 22px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:700;color:#ffffff;text-decoration:none;white-space:nowrap;">
                            Upgrade Now →
                          </a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- DIVIDER -->
    <tr>
      <td style="padding:16px 40px 0 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr><td style="height:1px;background:#E5EAF3;font-size:0;">&nbsp;</td></tr>
        </table>
      </td>
    </tr>

    <!-- SUPPORT BOX -->
    <tr>
      <td class="body-td" style="padding:20px 40px 8px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="background:#FFFBEB;border:1px solid #FDE68A;border-left:4px solid #F59E0B;border-radius:10px;">
          <tr>
            <td style="padding:14px 18px;">
              <p style="margin:0 0 10px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#92400E;letter-spacing:1px;text-transform:uppercase;">
                📞 &nbsp;QuickDials Support
              </p>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="padding:3px 0;font-family:Arial,Helvetica,sans-serif;font-size:12.5px;color:#78350F;">
                    <strong>✉️ Email:</strong>&nbsp;
                    <a href="mailto:care@quickdials.com"
                       style="color:#005DFF;text-decoration:none;font-weight:600;">
                      care@quickdials.com
                    </a>
                  </td>
                </tr>
                <tr>
                  <td style="padding:3px 0;font-family:Arial,Helvetica,sans-serif;font-size:12.5px;color:#78350F;">
                    <strong>📱 Phone:</strong>&nbsp;
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

    <!-- REGARDS -->
    <tr>
      <td style="padding:16px 40px 24px 40px;font-family:Arial,Helvetica,sans-serif;font-size:13.5px;color:#374151;line-height:1.8;">
        <p style="margin:0 0 4px 0;">Warm Regards,</p>
        <strong style="color:#0D1340;font-size:14px;">Team QuickDials Pvt. Ltd.</strong><br>
        <a href="https://www.quickdials.com" target="_blank"
           style="color:#005DFF;text-decoration:none;font-size:12px;">
          www.quickdials.com
        </a>
      </td>
    </tr>

    <!-- SYSTEM NOTE -->
    <tr>
      <td style="padding:0 40px 24px 40px;">
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

    <!-- FOOTER -->
    <tr>
      <td class="footer-td"
          style="background:linear-gradient(135deg,#0D1340,#1A2463);padding:24px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:11px;color:rgba(255,255,255,.6);line-height:1.8;">
              <strong style="color:rgba(255,255,255,.9);">QuickDials Pvt. Ltd.</strong><br>
              UNIT 101 Oxford Towers, 139/88 HAL Old Airport Rd,<br>
              Bangalore North — 560008, Karnataka, India.
            </td>
            <td valign="top" align="right"
                style="font-family:Arial,Helvetica,sans-serif;font-size:11px;text-align:right;">
              <a href="https://quickdials.com/privacy-policy" target="_blank"
                 style="color:rgba(255,255,255,.65);text-decoration:none;display:block;margin-bottom:5px;">
                Privacy Policy
              </a>
              <a href="https://quickdials.com/pricing" target="_blank"
                 style="color:rgba(255,255,255,.65);text-decoration:none;display:block;margin-bottom:5px;">
                Upgrade Plan
              </a>
             
            </td>
          </tr>
          <tr>
            <td colspan="2"
                style="padding-top:14px;font-family:Arial,Helvetica,sans-serif;font-size:10.5px;color:rgba(255,255,255,.3);border-top:1px solid rgba(255,255,255,.1);text-align:center;">
              © <?php echo date('Y'); ?> QuickDials Pvt. Ltd. All rights reserved.
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- BOTTOM ACCENT -->
    <tr>
      <td style="font-size:0;line-height:0;height:5px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td style="background:#005DFF;height:5px;width:25%;font-size:0;">&nbsp;</td>
            <td style="background:#FB641B;height:5px;width:25%;font-size:0;">&nbsp;</td>
            <td style="background:#005DFF;height:5px;width:25%;font-size:0;">&nbsp;</td>
            <td style="background:#FB641B;height:5px;width:25%;font-size:0;">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>

  </table>
</td></tr>
</table>

</body>
</html>
