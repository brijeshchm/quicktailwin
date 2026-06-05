<?php
/**
 * Mail Template — New Client Registration Welcome Email
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
  <title>Welcome to QuickDials — Registration Successful</title>
 
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
      .stat-td{padding:14px 8px!important;}
      .stat-num{font-size:20px!important;}
      .steps-td{padding:14px!important;}
      .btn-a{padding:14px 28px!important;font-size:14px!important;}
    }

    @media (prefers-color-scheme:dark){
      .dark-bg{background-color:#1a1f3a!important;}
      .dark-card{background-color:#242950!important;}
      .dark-text{color:#E5E7EB!important;}
    }
  </style>
</head>

<body style="margin:0;padding:0;background-color:#F0F4FF;font-family:Arial,Helvetica,sans-serif;">

<!-- Preheader -->
<div style="display:none;max-height:0;overflow:hidden;mso-hide:all;font-size:1px;color:#F0F4FF;">
  🎉 Welcome to QuickDials, <?php echo $client->business_name; ?>! Your account is ready. Here are your login credentials.
  &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
</div>

<!-- WRAPPER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#F0F4FF;">
<tr><td align="center" style="padding:30px 10px;">

  <!-- EMAIL CARD -->
  <table class="email-wrap" border="0" cellpadding="0" cellspacing="0" width="620"
         style="width:620px;max-width:620px;background-color:#ffffff;border-radius:18px;overflow:hidden;box-shadow:0 8px 40px rgba(0,93,255,.13);">

    <!-- TOP ACCENT — Blue + Orange brand colors -->
    <tr>
      <td style="font-size:0;line-height:0;height:5px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td style="background:#005DFF;height:5px;width:25%;font-size:0;line-height:0;">&nbsp;</td>
            <td style="background:#FB641B;height:5px;width:25%;font-size:0;line-height:0;">&nbsp;</td>
            <td style="background:#005DFF;height:5px;width:25%;font-size:0;line-height:0;">&nbsp;</td>
            <td style="background:#FB641B;height:5px;width:25%;font-size:0;line-height:0;">&nbsp;</td>
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
                <img src="<?php echo asset('client/images/quick-large-logo.png'); ?>"
                     alt="QuickDials" width="170"
                     style="width:170px;max-width:170px;height:auto;filter:brightness(0) invert(1);">
              </a>
            </td>
            <td class="hide-mob" width="45%" valign="middle" align="right"
                style="font-family:Arial,Helvetica,sans-serif;font-size:11px;color:rgba(255,255,255,.75);line-height:1.8;text-align:right;">
              <strong style="color:#fff;font-size:13px;display:block;margin-bottom:3px;">QuickDials Pvt. Ltd.</strong>
              Bengaluru, Karnataka, India<br>
              info@quickdials.com<br>
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
                style="padding:14px 12px;border-right:1px solid rgba(255,255,255,.1);">
              <div class="stat-num"
                   style="font-family:Arial,Helvetica,sans-serif;font-size:24px;font-weight:800;color:#FB641B;line-height:1;">
                10,000+
              </div>
              <div style="font-family:Arial,Helvetica,sans-serif;font-size:10px;color:rgba(255,255,255,.6);margin-top:4px;letter-spacing:.5px;text-transform:uppercase;">
                Institutes Served
              </div>
            </td>
            <td class="stat-td" width="33%" align="center"
                style="padding:14px 12px;border-right:1px solid rgba(255,255,255,.1);">
              <div class="stat-num"
                   style="font-family:Arial,Helvetica,sans-serif;font-size:24px;font-weight:800;color:#FB641B;line-height:1;">
                50,000+
              </div>
              <div style="font-family:Arial,Helvetica,sans-serif;font-size:10px;color:rgba(255,255,255,.6);margin-top:4px;letter-spacing:.5px;text-transform:uppercase;">
                Leads Generated
              </div>
            </td>
            <td class="stat-td" width="33%" align="center" style="padding:14px 12px;">
              <div class="stat-num"
                   style="font-family:Arial,Helvetica,sans-serif;font-size:24px;font-weight:800;color:#FB641B;line-height:1;">
                100+
              </div>
              <div style="font-family:Arial,Helvetica,sans-serif;font-size:10px;color:rgba(255,255,255,.6);margin-top:4px;letter-spacing:.5px;text-transform:uppercase;">
                Cities Covered
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- WELCOME BADGE -->
    <tr>
      <td align="center" style="padding:28px 40px 0 40px;">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td style="background:#ECFDF5;border:1px solid #A7F3D0;border-radius:20px;padding:7px 22px;">
              <span style="font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#059669;letter-spacing:1px;text-transform:uppercase;">
                🎉 &nbsp;Registration Successful
              </span>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- GREETING -->
    <tr>
      <td class="body-td" style="padding:20px 40px 8px 40px;">
        <h1 style="margin:0 0 10px 0;font-family:Arial,Helvetica,sans-serif;font-size:20px;font-weight:800;color:#0D1340;line-height:1.3;">
          Welcome  <?php echo $client->business_name; ?>! 
        </h1>
        <p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#4B5563;line-height:1.75;">
          You have successfully registered with <strong style="color:#005DFF;">QuickDials</strong>.
          Your account is now active and ready to use. Below are your registration details and login credentials.
        </p>
      </td>
    </tr>

    <!-- ACCOUNT DETAILS CARD -->
    <tr>
      <td class="body-td" style="padding:16px 40px 8px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="background:#F8FAFF;border:2px solid #005DFF;border-radius:12px;overflow:hidden;">

          <!-- Card Header -->
          <tr>
            <td colspan="2"
                style="background:linear-gradient(90deg,#005DFF,#2D8BFF);padding:13px 20px;">
              <span style="font-family:Arial,Helvetica,sans-serif;font-size:11.5px;font-weight:700;color:#ffffff;letter-spacing:1.5px;text-transform:uppercase;">
                🏢 &nbsp;Account Details
              </span>
            </td>
          </tr>

          <!-- Business Name -->
          <tr>
            <td style="padding:12px 20px;width:38%;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;border-bottom:1px solid #E5EAF3;">
              🏢 &nbsp;Business Name
            </td>
            <td style="padding:12px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:700;color:#0D1340;border-bottom:1px solid #E5EAF3;">
              <?php echo $client->business_name; ?>
            </td>
          </tr>

          <!-- City -->
          <tr>
            <td style="padding:12px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;border-bottom:1px solid #E5EAF3;">
              📍 &nbsp;City Registered In
            </td>
            <td style="padding:12px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;border-bottom:1px solid #E5EAF3;">
              <?php echo $client->city; ?>
            </td>
          </tr>

          <!-- Registered On -->
          <tr>
            <td style="padding:12px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;border-bottom:1px solid #E5EAF3;">
              📅 &nbsp;Registered On
            </td>
            <td style="padding:12px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;border-bottom:1px solid #E5EAF3;">
              <?php echo date('d M Y, H:i A'); ?> IST
            </td>
          </tr>

          <!-- Account Status -->
          <tr>
            <td style="padding:12px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;">
              ✅ &nbsp;Account Status
            </td>
            <td style="padding:12px 20px;border-bottom:none;">
              <span style="background:#ECFDF5;color:#059669;border:1px solid #A7F3D0;padding:3px 12px;border-radius:12px;font-size:11.5px;font-weight:700;font-family:Arial,Helvetica,sans-serif;">
                ● Active
              </span>
            </td>
          </tr>

        </table>
      </td>
    </tr>

    <!-- LOGIN CREDENTIALS CARD -->
    <tr>
      <td class="body-td" style="padding:16px 40px 24px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="background:#FFFBEB;border:2px solid #F59E0B;border-radius:12px;overflow:hidden;">

          <!-- Card Header -->
          <tr>
            <td colspan="2"
                style="background:linear-gradient(90deg,#D97706,#F59E0B);padding:13px 20px;">
              <span style="font-family:Arial,Helvetica,sans-serif;font-size:11.5px;font-weight:700;color:#ffffff;letter-spacing:1.5px;text-transform:uppercase;">
                🔐 &nbsp;Your Login Credentials
              </span>
            </td>
          </tr>

          <!-- User ID -->
          <tr>
            <td style="padding:14px 20px;width:38%;background:rgba(245,158,11,.08);font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#92400E;border-right:1px solid #FDE68A;border-bottom:1px solid #FDE68A;">
              👤 &nbsp;User ID
            </td>
            <td style="padding:14px 20px;font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:800;color:#0D1340;border-bottom:1px solid #FDE68A;letter-spacing:.5px;">
              <?php echo $usr; ?>
            </td>
          </tr>

          <!-- Password -->
          <tr>
            <td style="padding:14px 20px;background:rgba(245,158,11,.08);font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#92400E;border-right:1px solid #FDE68A;">
              🔑 &nbsp;Password
            </td>
            <td style="padding:14px 20px;font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:800;color:#0D1340;letter-spacing:1px;">
              <?php echo $pass; ?>
            </td>
          </tr>

        </table>

        <!-- Password Warning -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top:10px;">
          <tr>
            <td style="background:#FEF2F2;border:1px solid #FECACA;border-left:4px solid #EF4444;border-radius:8px;padding:10px 16px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#991B1B;line-height:1.6;">
              ⚠️ <strong>Important:</strong> This is a system generated password.
              Please <strong>change your password immediately</strong> after your first login for security.
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- CTA BUTTON -->
    <tr>
      <td align="center" style="padding:0 40px 28px 40px;">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center"
                style="background:linear-gradient(135deg,#005DFF,#2D8BFF);border-radius:10px;">
              <a class="btn-a" href="https://www.quickdials.com/login" target="_blank"
                 style="display:inline-block;padding:15px 44px;font-family:Arial,Helvetica,sans-serif;font-size:15px;font-weight:700;color:#ffffff;text-decoration:none;letter-spacing:.3px;">
                Login to Your Dashboard →
              </a>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- NEXT STEPS -->
    <tr>
      <td class="body-td" style="padding:0 40px 28px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="background:#F8FAFF;border:1px solid #DBEAFE;border-radius:12px;overflow:hidden;">
          <tr>
            <td style="background:linear-gradient(90deg,#EEF4FF,#F8FAFF);padding:12px 20px;border-bottom:1px solid #DBEAFE;">
              <span style="font-family:Arial,Helvetica,sans-serif;font-size:11.5px;font-weight:700;color:#005DFF;letter-spacing:1px;text-transform:uppercase;">
                🚀 &nbsp;Next Steps
              </span>
            </td>
          </tr>
          <tr>
            <td style="padding:16px 20px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">

                <!-- Step 1 -->
                <tr>
                  <td valign="top" style="padding:6px 0;">
                    <table border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td valign="top" style="padding-right:12px;">
                          <div style="background:#005DFF;color:#fff;width:24px;height:24px;border-radius:50%;font-family:Arial,Helvetica,sans-serif;font-size:11px;font-weight:700;text-align:center;line-height:24px;">
                            1
                          </div>
                        </td>
                        <td style="font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#374151;line-height:1.6;">
                          <strong style="color:#0D1340;">Login</strong> using the credentials above at
                          <a href="https://www.quickdials.com/login" target="_blank"
                             style="color:#005DFF;text-decoration:none;font-weight:600;">
                            quickdials.com/login
                          </a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

                <!-- Step 2 -->
                <tr>
                  <td valign="top" style="padding:6px 0;">
                    <table border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td valign="top" style="padding-right:12px;">
                          <div style="background:#FB641B;color:#fff;width:24px;height:24px;border-radius:50%;font-family:Arial,Helvetica,sans-serif;font-size:11px;font-weight:700;text-align:center;line-height:24px;">
                            2
                          </div>
                        </td>
                        <td style="font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#374151;line-height:1.6;">
                          <strong style="color:#0D1340;">Change your password</strong> immediately from account settings
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

                <!-- Step 3 -->
                <tr>
                  <td valign="top" style="padding:6px 0;">
                    <table border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td valign="top" style="padding-right:12px;">
                          <div style="background:#059669;color:#fff;width:24px;height:24px;border-radius:50%;font-family:Arial,Helvetica,sans-serif;font-size:11px;font-weight:700;text-align:center;line-height:24px;">
                            3
                          </div>
                        </td>
                        <td style="font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#374151;line-height:1.6;">
                          <strong style="color:#0D1340;">Complete your profile</strong> and start receiving leads
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
      <td style="padding:0 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr><td style="height:1px;background:#E5EAF3;font-size:0;line-height:0;">&nbsp;</td></tr>
        </table>
      </td>
    </tr>

    <!-- SUPPORT BOX -->
    <tr>
      <td class="body-td" style="padding:24px 40px;">
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
                    <strong>✉️ Email:</strong>&nbsp;
                    <a href="mailto:info@quickdials.com"
                       style="color:#005DFF;text-decoration:none;font-weight:600;">
                      info@quickdials.com
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
                <tr>
                  <td style="padding:3px 0;font-family:Arial,Helvetica,sans-serif;font-size:12.5px;color:#78350F;">
                    <strong>🌐 Website:</strong>&nbsp;
                    <a href="https://www.quickdials.com" target="_blank"
                       style="color:#005DFF;text-decoration:none;font-weight:600;">
                      www.quickdials.com
                    </a>
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
      <td style="padding:0 40px 28px 40px;font-family:Arial,Helvetica,sans-serif;font-size:13.5px;color:#374151;line-height:1.8;">
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

    <!-- FOOTER -->
    <tr>
      <td class="footer-td"
          style="background:linear-gradient(135deg,#0D1340,#1A2463);padding:24px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:11px;color:rgba(255,255,255,.6);line-height:1.8;">
              <strong style="color:rgba(255,255,255,.9);">QuickDials Pvt. Ltd.</strong><br>
              UNIT 101 Oxford Towers, 139/88 HAL Old Airport Rd,<br>
              Bangalore North — 560008, Karnataka, India.<br>
              CIN: U63112KA2026PTC215594 &nbsp;|&nbsp; TAN: BLRQ01951F
            </td>
            <td valign="top" align="right"
                style="font-family:Arial,Helvetica,sans-serif;font-size:11px;text-align:right;">
              <a href="https://quickdials.com/privacy-policy" target="_blank"
                 style="color:rgba(255,255,255,.65);text-decoration:none;display:block;margin-bottom:5px;">
                Privacy Policy
              </a>
              <a href="https://quickdials.com/privacy-policy" target="_blank"
                 style="color:rgba(255,255,255,.65);text-decoration:none;display:block;margin-bottom:5px;">
                Terms of Service
              </a>
              <a href="https://quickdials.com/privacy-policy" target="_blank"
                 style="color:rgba(255,255,255,.65);text-decoration:none;display:block;">
                Unsubscribe
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
            <td style="background:#005DFF;height:5px;width:25%;font-size:0;line-height:0;">&nbsp;</td>
            <td style="background:#FB641B;height:5px;width:25%;font-size:0;line-height:0;">&nbsp;</td>
            <td style="background:#005DFF;height:5px;width:25%;font-size:0;line-height:0;">&nbsp;</td>
            <td style="background:#FB641B;height:5px;width:25%;font-size:0;line-height:0;">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>

  </table>
  <!-- /EMAIL CARD -->

</td></tr>
</table>
<!-- /WRAPPER -->

</body>
</html>
