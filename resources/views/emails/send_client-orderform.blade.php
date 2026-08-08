<?php
/**
 * Mail Template — Order Confirmation Email
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
  <title>Order Confirmation — QuickDials #<?php echo $order_number; ?></title>
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
      .two-col{display:block!important;width:100%!important;}
      .two-col td{display:block!important;width:100%!important;padding:8px 0!important;}
    }
  </style>
</head>

<body style="margin:0;padding:0;background-color:#F0F4FF;font-family:Arial,Helvetica,sans-serif;">

<!-- Preheader -->
<div style="display:none;max-height:0;overflow:hidden;mso-hide:all;font-size:1px;color:#F0F4FF;">
  ✅ Order #<?php echo $order_number; ?> confirmed! Your QuickDials order has been successfully created. View full details inside.
  &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
</div>

<!-- WRAPPER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#F0F4FF;">
<tr><td align="center" style="padding:30px 10px;">

  <!-- EMAIL CARD -->
  <table class="email-wrap" border="0" cellpadding="0" cellspacing="0" width="640"
         style="width:640px;max-width:640px;background-color:#ffffff;border-radius:18px;overflow:hidden;box-shadow:0 8px 40px rgba(0,93,255,.13);">

    <!-- TOP ACCENT -->
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
            <td width="50%" valign="middle">
              <a href="https://www.quickdials.com" target="_blank" style="text-decoration:none;">
                <img src="https://www.quickdials.com/client/images/quick-large-logo.png"
                     alt="QuickDials" width="170"
                     style="width:170px;max-width:170px;height:auto;filter:brightness(0) invert(1);">
              </a>
            </td>
            <td class="hide-mob" width="50%" valign="middle" align="right"
                style="font-family:Arial,Helvetica,sans-serif;font-size:11px;color:rgba(255,255,255,.75);line-height:1.8;text-align:right;">
              <strong style="color:#fff;font-size:13px;display:block;margin-bottom:3px;">QuickDials Pvt. Ltd.</strong>
              UNIT 101 Oxford Towers, faridabad — 560008<br>
              📞 +91-75-5943-5943 &nbsp;|&nbsp; info@quickdials.com<br>
              CIN: U63112KA2026PTC215594
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- ORDER CONFIRMED BADGE -->
    <tr>
      <td align="center" style="background:#001F8C;padding:14px 40px;">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td style="background:rgba(16,185,129,.2);border:1px solid rgba(16,185,129,.4);border-radius:20px;padding:7px 22px;">
              <span style="font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#6EE7B7;letter-spacing:1px;text-transform:uppercase;">
                ✅ &nbsp;Order Successfully Created — #<?php echo $order_number; ?>
              </span>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- GREETING -->
    <tr>
      <td class="body-td" style="padding:28px 40px 10px 40px;">
        <h1 style="margin:0 0 10px 0;font-family:Arial,Helvetica,sans-serif;font-size:20px;font-weight:800;color:#0D1340;line-height:1.3;">
          Hi <?php echo $client->business_name; ?>! 🎉
        </h1>
        <p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#4B5563;line-height:1.75;">
          We are privileged to serve you and we greatly value our relationship!
          Your order has been <strong style="color:#059669;">successfully created</strong>.
          Here are your complete order details:
        </p>
      </td>
    </tr>

    <!-- ══ ORDER DETAILS CARD ══ -->
    <tr>
      <td class="body-td" style="padding:16px 40px 8px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="background:#F8FAFF;border:2px solid #005DFF;border-radius:12px;overflow:hidden;">
          <tr>
            <td colspan="2" style="background:linear-gradient(90deg,#005DFF,#2D8BFF);padding:13px 20px;">
              <span style="font-family:Arial,Helvetica,sans-serif;font-size:11.5px;font-weight:700;color:#fff;letter-spacing:1.5px;text-transform:uppercase;">
                📋 &nbsp;Order Details
              </span>
            </td>
          </tr>
          <!-- Order Number -->
          <tr>
            <td style="padding:11px 20px;width:38%;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;border-bottom:1px solid #E5EAF3;">
              🔢 &nbsp;Order Number
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:800;color:#0D1340;border-bottom:1px solid #E5EAF3;letter-spacing:.5px;">
              #<?php echo $order_number; ?>
            </td>
          </tr>
          <!-- Order Date -->
          <tr>
            <td style="padding:11px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;border-bottom:1px solid #E5EAF3;">
              📅 &nbsp;Order Date
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;border-bottom:1px solid #E5EAF3;">
              <?php echo date('d M Y'); ?>
            </td>
          </tr>
          <!-- Customer Name -->
          <tr>
            <td style="padding:11px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;border-bottom:1px solid #E5EAF3;">
              👤 &nbsp;Customer Name
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;border-bottom:1px solid #E5EAF3;">
              <?php echo $client->first_name.' '.$client->last_name; ?>
            </td>
          </tr>
          <!-- Phone -->
          <tr>
            <td style="padding:11px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;border-bottom:1px solid #E5EAF3;">
              📱 &nbsp;Phone
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;border-bottom:1px solid #E5EAF3;">
              <a href="tel:<?php echo $client->mobile; ?>" style="color:#005DFF;text-decoration:none;">
                <?php echo $client->mobile; ?>
              </a>
            </td>
          </tr>
          <!-- Business Name -->
          <tr>
            <td style="padding:11px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;border-bottom:1px solid #E5EAF3;">
              🏢 &nbsp;Business Name
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:700;color:#0D1340;border-bottom:1px solid #E5EAF3;">
              <?php echo $client->business_name; ?>
            </td>
          </tr>
          <!-- Package -->
          <tr>
            <td style="padding:11px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;border-bottom:1px solid #E5EAF3;">
              📦 &nbsp;Package Name
            </td>
            <td style="padding:11px 20px;border-bottom:1px solid #E5EAF3;">
              <?php
                $pkgName = '';
                $pkgClass = '';
                if($client->package_status == 1){ $pkgName='Diamond'; $pkgClass='background:linear-gradient(135deg,#0284C7,#38BDF8);'; }
                elseif($client->package_status == 2){ $pkgName='Gold'; $pkgClass='background:linear-gradient(135deg,#D97706,#F59E0B);'; }
                elseif($client->package_status == 3){ $pkgName='Platinum'; $pkgClass='background:linear-gradient(135deg,#6D28D9,#A78BFA);'; }
              ?>
              <span style="<?php echo $pkgClass; ?>color:#fff;padding:3px 14px;border-radius:12px;font-size:12px;font-weight:700;font-family:Arial,Helvetica,sans-serif;">
                <?php
                  if($client->package_status==1) echo '💎 ';
                  elseif($client->package_status==2) echo '⭐ ';
                  elseif($client->package_status==3) echo '👑 ';
                  echo $pkgName;
                ?>
              </span>
            </td>
          </tr>
          <!-- Duration -->
          <?php if(!empty($client->expired_from)): ?>
          <tr>
            <td style="padding:11px 20px;background:#EEF4FF;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#005DFF;border-right:1px solid #E5EAF3;">
              📆 &nbsp;Duration
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;">
              <?php echo date('d M Y',strtotime($client->expired_from)); ?>
              &nbsp;→&nbsp;
              <?php echo date('d M Y',strtotime($client->expired_on)); ?>
            </td>
          </tr>
          <?php endif; ?>
        </table>
      </td>
    </tr>

    <!-- ══ PAYMENT DETAILS CARD ══ -->
    <tr>
      <td class="body-td" style="padding:16px 40px 8px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="background:#FFFBEB;border:2px solid #F59E0B;border-radius:12px;overflow:hidden;">
          <tr>
            <td colspan="2" style="background:linear-gradient(90deg,#D97706,#F59E0B);padding:13px 20px;">
              <span style="font-family:Arial,Helvetica,sans-serif;font-size:11.5px;font-weight:700;color:#fff;letter-spacing:1.5px;text-transform:uppercase;">
                💳 &nbsp;Payment Details
              </span>
            </td>
          </tr>
          <!-- Amount Paid -->
          <tr>
            <td style="padding:11px 20px;width:38%;background:rgba(245,158,11,.08);font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#92400E;border-right:1px solid #FDE68A;border-bottom:1px solid #FDE68A;">
              💰 &nbsp;Amount Paid
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:700;color:#0D1340;border-bottom:1px solid #FDE68A;">
              ₹ <?php echo number_format($paid_amount, 2); ?>
            </td>
          </tr>
          <!-- GST -->
          <tr>
            <td style="padding:11px 20px;background:rgba(245,158,11,.08);font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#92400E;border-right:1px solid #FDE68A;border-bottom:1px solid #FDE68A;">
              🧾 &nbsp;GST
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;border-bottom:1px solid #FDE68A;">
              ₹ <?php echo $gst_tax ? number_format($gst_tax,2) : '0.00'; ?>
            </td>
          </tr>
          <!-- TDS -->
          <tr>
            <td style="padding:11px 20px;background:rgba(245,158,11,.08);font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#92400E;border-right:1px solid #FDE68A;border-bottom:1px solid #FDE68A;">
              📊 &nbsp;TDS (@2%)
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;border-bottom:1px solid #FDE68A;">
              ₹ <?php echo $tds_amount ? number_format($tds_amount,2) : '0.00'; ?>
            </td>
          </tr>
          <!-- Total -->
          <tr>
            <td style="padding:12px 20px;background:#D97706;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#fff;border-right:1px solid #F59E0B;border-bottom:1px solid #FDE68A;">
              💵 &nbsp;Total Amount
            </td>
            <td style="padding:12px 20px;background:#D97706;font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:800;color:#fff;border-bottom:1px solid #FDE68A;">
              ₹ <?php echo number_format($total_amount, 2); ?> INR
            </td>
          </tr>
          <!-- Amount in Words -->
          <tr>
            <td style="padding:11px 20px;background:rgba(245,158,11,.08);font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#92400E;border-right:1px solid #FDE68A;border-bottom:1px solid #FDE68A;">
              💬 &nbsp;Amount in Words
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#374151;font-style:italic;border-bottom:1px solid #FDE68A;">
              <?php echo $paid_amt_in_words; ?>
            </td>
          </tr>
          <!-- Mode -->
          <tr>
            <td style="padding:11px 20px;background:rgba(245,158,11,.08);font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#92400E;border-right:1px solid #FDE68A;border-bottom:1px solid #FDE68A;">
              🏦 &nbsp;Mode of Payment
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;border-bottom:1px solid #FDE68A;">
              <?php echo ucfirst($payment_mode); ?>
            </td>
          </tr>
          <?php if(!empty($paymentupdate->chq_card_no)): ?>
          <!-- Cheque -->
          <tr>
            <td style="padding:11px 20px;background:rgba(245,158,11,.08);font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#92400E;border-right:1px solid #FDE68A;border-bottom:1px solid #FDE68A;">
              📝 &nbsp;Cheque No
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:600;color:#0D1340;border-bottom:1px solid #FDE68A;">
              <?php echo $paymentupdate->chq_card_no; ?>
            </td>
          </tr>
          <?php endif; ?>
          <!-- Pay Mode Details -->
          <tr>
            <td style="padding:11px 20px;background:rgba(245,158,11,.08);font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#92400E;border-right:1px solid #FDE68A;border-bottom:1px solid #FDE68A;">
              🔖 &nbsp;Pay Mode Details
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#374151;border-bottom:1px solid #FDE68A;">
              <?php echo $pay_mode_details; ?>
            </td>
          </tr>
          <!-- Transaction ID -->
          <tr>
            <td style="padding:11px 20px;background:rgba(245,158,11,.08);font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#92400E;border-right:1px solid #FDE68A;">
              🔗 &nbsp;Transaction ID
            </td>
            <td style="padding:11px 20px;font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:700;color:#0D1340;letter-spacing:.5px;">
              #<?php echo $transactionid; ?>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- ══ LISTING DETAILS ══ -->
    <?php if(!empty($assignKeyword)): ?>
    <tr>
      <td class="body-td" style="padding:16px 40px 8px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="background:#fff;border:1px solid #E5EAF3;border-radius:12px;overflow:hidden;">
          <tr>
            <td style="background:linear-gradient(90deg,#005DFF,#2D8BFF);padding:13px 20px;">
              <span style="font-family:Arial,Helvetica,sans-serif;font-size:11.5px;font-weight:700;color:#fff;letter-spacing:1.5px;text-transform:uppercase;">
                📍 &nbsp;Listing Details
              </span>
            </td>
          </tr>
          <tr>
            <td style="padding:0;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <!-- Table Header -->
                <tr style="background:#EEF4FF;">
                  <td style="padding:10px 16px;font-family:Arial,Helvetica,sans-serif;font-size:11px;font-weight:700;color:#005DFF;letter-spacing:.8px;text-transform:uppercase;border-bottom:1px solid #E5EAF3;width:25%;">
                    City
                  </td>
                  <td style="padding:10px 16px;font-family:Arial,Helvetica,sans-serif;font-size:11px;font-weight:700;color:#005DFF;letter-spacing:.8px;text-transform:uppercase;border-bottom:1px solid #E5EAF3;width:25%;">
                    Category
                  </td>
                  <td style="padding:10px 16px;font-family:Arial,Helvetica,sans-serif;font-size:11px;font-weight:700;color:#005DFF;letter-spacing:.8px;text-transform:uppercase;border-bottom:1px solid #E5EAF3;width:25%;">
                    Sub Category
                  </td>
                  <td style="padding:10px 16px;font-family:Arial,Helvetica,sans-serif;font-size:11px;font-weight:700;color:#005DFF;letter-spacing:.8px;text-transform:uppercase;border-bottom:1px solid #E5EAF3;width:25%;">
                    Keyword
                  </td>
                </tr>
                <?php $i=0; foreach($assignKeyword as $keyword): $i++; ?>
                <tr style="background:<?php echo ($i%2==0)?'#F8FAFF':'#fff'; ?>;">
                  <td style="padding:10px 16px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#374151;border-bottom:1px solid #F3F4F6;">
                    <?php echo $keyword->city; ?>
                  </td>
                  <td style="padding:10px 16px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#374151;border-bottom:1px solid #F3F4F6;">
                    <?php echo $keyword->parent_category; ?>
                  </td>
                  <td style="padding:10px 16px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#374151;border-bottom:1px solid #F3F4F6;">
                    <?php echo $keyword->child_category; ?>
                  </td>
                  <td style="padding:10px 16px;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:600;color:#005DFF;border-bottom:1px solid #F3F4F6;">
                    <?php echo $keyword->keyword; ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <?php endif; ?>

    <!-- ══ IMPORTANT NOTES ══ -->
    <tr>
      <td class="body-td" style="padding:16px 40px 8px 40px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%"
               style="background:#FFFBEB;border:1px solid #FDE68A;border-left:4px solid #F59E0B;border-radius:10px;">
          <tr>
            <td style="padding:16px 20px;">
              <p style="margin:0 0 12px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:700;color:#92400E;letter-spacing:1px;text-transform:uppercase;">
                ⚠️ &nbsp;Important Notes
              </p>
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td style="padding:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#78350F;line-height:1.6;">
                    → You can check your balance value and pending lead details after logging into
                    <a href="https://www.quickdials.com" target="_blank" style="color:#005DFF;font-weight:600;text-decoration:none;">quickdials.com</a>
                  </td>
                </tr>
                <tr>
                  <td style="padding:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#78350F;line-height:1.6;">
                    → No verbal or written commitment outside this order form will be considered.
                  </td>
                </tr>
                <tr>
                  <td style="padding:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#78350F;line-height:1.6;">
                    → Your advertisement will be activated within <strong>3 days</strong> of payment clearance.
                  </td>
                </tr>
                <tr>
                  <td style="padding:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#78350F;line-height:1.6;">
                    → Applicable TDS rate is <strong>@2%</strong> under Section 194C on net amount excluding tax.
                  </td>
                </tr>
                <tr>
                  <td style="padding:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#78350F;line-height:1.6;">
                    → Timings: Monday to Sunday — 24/7
                  </td>
                </tr>
                <tr>
                  <td style="padding:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#78350F;line-height:1.6;">
                    → For queries: Call <strong>1800-000-000</strong> or email
                    <a href="mailto:help@quickdials.com" style="color:#005DFF;font-weight:600;text-decoration:none;">help@quickdials.com</a>
                  </td>
                </tr>
                <tr>
                  <td style="padding:8px 0 0 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#78350F;">
                    →
                    <a href="https://www.quickdials.com/official/privacy-policy" target="_blank"
                       style="color:#005DFF;font-weight:700;text-decoration:none;">
                      View Terms &amp; Conditions
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
      <td style="padding:20px 40px 28px 40px;font-family:Arial,Helvetica,sans-serif;font-size:13.5px;color:#374151;line-height:1.8;">
        <p style="margin:0 0 4px 0;">Looking forward to a long and fruitful association with you!</p>
        <p style="margin:0 0 4px 0;">Sincerely,</p>
        <strong style="color:#0D1340;font-size:14px;">Team QuickDials Pvt. Ltd.</strong><br>
        <a href="https://www.quickdials.com" target="_blank"
           style="color:#005DFF;text-decoration:none;font-size:12px;">www.quickdials.com</a>
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
              Contact us at <a href="mailto:help@quickdials.com" style="color:#005DFF;">help@quickdials.com</a> for any queries.
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
              faridabad North — 560008, Karnataka, India.<br>
              CIN: U63112KA2026PTC215594 &nbsp;|&nbsp; TAN: BLRQ01951F
            </td>
            <td valign="top" align="right"
                style="font-family:Arial,Helvetica,sans-serif;font-size:11px;text-align:right;">
              <a href="https://quickdials.com/official/privacy-policy" target="_blank"
                 style="color:rgba(255,255,255,.65);text-decoration:none;display:block;margin-bottom:5px;">
                Privacy Policy
              </a>
              <a href="https://quickdials.com/official/privacy-policy" target="_blank"
                 style="color:rgba(255,255,255,.65);text-decoration:none;display:block;margin-bottom:5px;">
                Terms of Service
              </a>
              <a href="https://quickdials.com/official/privacy-policy" target="_blank"
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
