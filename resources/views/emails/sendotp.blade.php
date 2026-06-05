<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="x-apple-disable-message-reformatting">
  <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
  <title>OTP Verification — QuickDials</title>
 
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
      .otp-box{padding:24px 16px!important;}
      .otp-code{font-size:36px!important;letter-spacing:10px!important;}
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
  🔐 Your QuickDials OTP is: <?php echo $lead; ?> — Valid for 10 minutes. Do not share with anyone.
  &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
</div>

<!-- WRAPPER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#F0F4FF;">
<tr><td align="center" style="padding:30px 10px;">

  <!-- EMAIL CARD -->
  <table class="email-wrap" border="0" cellpadding="0" cellspacing="0" width="560"
         style="width:560px;max-width:560px;background-color:#ffffff;border-radius:18px;overflow:hidden;box-shadow:0 8px 40px rgba(0,93,255,.13);">

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
          style="background:linear-gradient(135deg,#001F8C 0%,#005DFF 55%,#2D8BFF 100%);padding:30px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td valign="middle">
              <a href="https://www.quickdials.com" target="_blank" style="text-decoration:none;">
                <img src="<?php echo asset('client/images/quick-large-logo.png'); ?>"
                     alt="QuickDials" width="160"
                     style="width:160px;max-width:160px;height:auto;filter:brightness(0) invert(1);">
              </a>
            </td>
            <td class="hide-mob" valign="middle" align="right"
                style="font-family:Arial,Helvetica,sans-serif;font-size:11px;color:rgba(255,255,255,.75);line-height:1.85;text-align:right;">
              <strong style="color:#fff;font-size:12px;display:block;margin-bottom:2px;">QuickDials Pvt. Ltd.</strong>
              care@quickdials.com<br>
              +91-75-5943-5943
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- SECURITY BADGE -->
    <tr>
      <td align="center" style="background:#001F8C;padding:12px 40px;">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.22);border-radius:20px;padding:6px 20px;">
              <span style="font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#ffffff;letter-spacing:1px;text-transform:uppercase;">
                🔐 &nbsp;Security Verification
              </span>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- LOCK ICON + HEADLINE -->
    <tr>
      <td class="body-td" align="center" style="padding:36px 40px 8px 40px;">
        <div style="font-size:52px;line-height:1;margin-bottom:16px;">🔑</div>
        <h1 style="margin:0 0 10px 0;font-family:Arial,Helvetica,sans-serif;font-size:22px;font-weight:800;color:#0D1340;line-height:1.3;">
          Verify Your Identity
        </h1>
        <p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#4B5563;line-height:1.75;max-width:420px;">
          Hi there! Use the One-Time Password below to complete your verification on <strong style="color:#005DFF;">QuickDials</strong>.
        </p>
      </td>
    </tr>

    <!-- OTP BOX -->
    <tr>
      <td class="body-td" align="center" style="padding:24px 40px;">
        <table class="otp-box" border="0" cellpadding="0" cellspacing="0"
               style="background:linear-gradient(135deg,#EEF4FF,#F0F8FF);border:2px dashed #005DFF;border-radius:16px;padding:32px 40px;width:100%;max-width:400px;">
          <tr>
            <td align="center">
              <p style="margin:0 0 10px 0;font-family:Arial,Helvetica,sans-serif;font-size:11.5px;font-weight:700;color:#005DFF;letter-spacing:2px;text-transform:uppercase;">
                Your One-Time Password
              </p>
              <div class="otp-code"
                   style="font-family:Arial,Helvetica,sans-serif;font-size:44px;font-weight:900;color:#0D1340;letter-spacing:14px;line-height:1.2;margin:10px 0;background:linear-gradient(135deg,#005DFF,#2D8BFF);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                <?php echo $lead; ?>
              </div>
              <p style="margin:12px 0 0 0;font-family:Arial,Helvetica,sans-serif;font-size:11.5px;color:#6B7280;">
                ⏱️ Valid for <strong style="color:#DC2626;">10 minutes</strong> only
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- SECURITY WARNINGS -->
    <tr>
      <td class="body-td" style="padding:0 40px 24px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="background:#FEF2F2;border:1px solid #FECACA;border-left:4px solid #EF4444;border-radius:10px;">
          <tr>
            <td style="padding:14px 18px;">
              <p style="margin:0 0 8px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#991B1B;letter-spacing:1px;text-transform:uppercase;">
                🛡️ &nbsp;Security Tips
              </p>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="padding:3px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#7F1D1D;line-height:1.6;">
                    → <strong>Never share</strong> this OTP with anyone, including QuickDials staff.
                  </td>
                </tr>
                <tr>
                  <td style="padding:3px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#7F1D1D;line-height:1.6;">
                    → This OTP is valid for <strong>10 minutes</strong> and can only be used once.
                  </td>
                </tr>
                <tr>
                  <td style="padding:3px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#7F1D1D;line-height:1.6;">
                    → If you did not request this OTP, please <strong>ignore this email</strong> or contact us immediately.
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
          <tr><td style="height:1px;background:#E5EAF3;font-size:0;">&nbsp;</td></tr>
        </table>
      </td>
    </tr>

    <!-- SUPPORT -->
    <tr>
      <td class="body-td" style="padding:20px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="background:#FFFBEB;border:1px solid #FDE68A;border-left:4px solid #F59E0B;border-radius:10px;">
          <tr>
            <td style="padding:14px 18px;">
              <p style="margin:0 0 8px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#92400E;letter-spacing:1px;text-transform:uppercase;">
                📞 &nbsp;Need Help?
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
                    &nbsp;(24/7)
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
      <td style="padding:0 40px 24px 40px;font-family:Arial,Helvetica,sans-serif;font-size:13.5px;color:#374151;line-height:1.8;">
        <p style="margin:0 0 4px 0;">Warm Regards,</p>
        <strong style="color:#0D1340;font-size:14px;">Team QuickDials Pvt. Ltd.</strong><br>
        <a href="https://www.quickdials.com" target="_blank"
           style="color:#005DFF;text-decoration:none;font-size:12px;">www.quickdials.com</a>
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
              Contact us at <a href="mailto:care@quickdials.com" style="color:#005DFF;text-decoration:none;">care@quickdials.com</a> for any queries or clarification.
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
