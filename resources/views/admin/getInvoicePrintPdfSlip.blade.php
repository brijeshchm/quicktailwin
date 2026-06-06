<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QuickDials — E-Invoice <?php echo date('d-m-Y H:i:s'); ?></title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap');

*,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}

:root{
  --brand:#005DFF;
  --brand-dk:#0042CC;
  --brand-lt:#EEF4FF;
  --green:#059669;
  --green-lt:#ECFDF5;
  --amber:#D97706;
  --amber-lt:#FFFBEB;
  --dark:#0D1340;
  --body:#374151;
  --muted:#6B7280;
  --border:#E5EAF3;
  --bg:#F4F7FF;
  --white:#FFFFFF;
}

body{
  font-family:'Inter',Arial,sans-serif;
  background:var(--bg);
  color:var(--body);
  font-size:13px;
  line-height:1.6;
  -webkit-font-smoothing:antialiased;
}

/* ── WRAPPER ── */
.inv-wrap{
  max-width:880px;
  margin:30px auto;
  background:var(--white);
  border-radius:20px;
  overflow:hidden;
  box-shadow:0 24px 80px rgba(0,93,255,.13);
}

/* ══ HEADER ══ */
.inv-header{
  background:linear-gradient(135deg,#001F8C 0%,#005DFF 55%,#2D8BFF 100%);
  position:relative;
  overflow:hidden;
}
.inv-header::before{
  content:'';position:absolute;top:-80px;right:-80px;
  width:280px;height:280px;border-radius:50%;
  background:rgba(255,255,255,.06);
}
.inv-header::after{
  content:'';position:absolute;bottom:-100px;left:35%;
  width:200px;height:200px;border-radius:50%;
  background:rgba(255,255,255,.04);
}

.header-inner{
  display:flex;
  align-items:stretch;
  position:relative;
  z-index:1;
}

/* Left brand */
.h-left{
  flex:1;
  padding:36px 40px;
  color:#fff;
}
.h-left img{
  height:46px;
  filter:brightness(0) invert(1);
  margin-bottom:14px;
  display:block;
}
.h-left .co-name{
  font-family:'Playfair Display',serif;
  font-size:21px;font-weight:800;
  letter-spacing:-.3px;margin-bottom:8px;
}
.h-left .co-info{
  font-size:11.5px;opacity:.78;line-height:1.85;
}
.h-left .co-info a{color:rgba(255,255,255,.85);text-decoration:none;}

/* Right meta */
.h-right{
  background:rgba(0,0,0,.2);
  backdrop-filter:blur(10px);
  padding:36px 36px;
  min-width:230px;
  color:#fff;
  display:flex;flex-direction:column;justify-content:center;
  border-left:1px solid rgba(255,255,255,.1);
}
.h-right .doc-lbl{
  font-size:10px;font-weight:700;
  letter-spacing:2.5px;text-transform:uppercase;
  opacity:.6;margin-bottom:5px;
}
.h-right .doc-type{
  font-family:'Playfair Display',serif;
  font-size:28px;font-weight:800;line-height:1.1;
  margin-bottom:18px;
}
.h-right .e-badge{
  display:inline-flex;align-items:center;gap:6px;
  background:var(--green);
  color:#fff;padding:5px 14px;
  border-radius:20px;font-size:11px;font-weight:700;
  letter-spacing:.5px;margin-bottom:16px;
  width:fit-content;
}
.h-right .mr{
  display:flex;justify-content:space-between;align-items:center;
  padding:7px 0;border-bottom:1px solid rgba(255,255,255,.1);
  font-size:11.5px;
}
.h-right .mr:last-child{border-bottom:none;}
.h-right .mr .mk{opacity:.6;font-weight:500;}
.h-right .mr .mv{font-weight:700;}

/* ── REG BAR ── */
.reg-bar{
  background:#001F8C;
  padding:10px 40px;
  display:flex;gap:28px;flex-wrap:wrap;
}
.reg-item{
  display:flex;align-items:center;gap:7px;
  font-size:11px;color:rgba(255,255,255,.65);
}
.reg-item strong{color:rgba(255,255,255,.95);font-weight:700;}

/* ══ BODY ══ */
.inv-body{padding:36px 40px;}

.sec-title{
  display:flex;align-items:center;gap:10px;
  font-size:10.5px;font-weight:800;
  letter-spacing:2px;text-transform:uppercase;
  color:var(--brand);margin-bottom:14px;
}
.sec-title::after{
  content:'';flex:1;height:2px;
  background:linear-gradient(90deg,var(--brand-lt),transparent);
  border-radius:2px;
}
.sec-title .si{
  width:24px;height:24px;
  background:var(--brand-lt);border-radius:6px;
  display:flex;align-items:center;justify-content:center;
  font-size:13px;
}

/* ── PARTY CARDS ── */
.parties-grid{
  display:grid;grid-template-columns:1fr 1fr;
  gap:20px;margin-bottom:32px;
}
.p-card{
  background:var(--bg);
  border:1px solid var(--border);
  border-radius:14px;overflow:hidden;
}
.p-card .ph{
  background:linear-gradient(90deg,var(--brand-lt),#F8FAFF);
  border-bottom:1px solid var(--border);
  padding:10px 18px;
  font-size:10.5px;font-weight:800;
  letter-spacing:1.5px;text-transform:uppercase;
  color:var(--brand);
  display:flex;align-items:center;gap:7px;
}
.p-card .pb{padding:16px 18px;}
.p-card .biz{
  font-size:15px;font-weight:700;
  color:var(--dark);margin-bottom:10px;
}
.p-card .il{
  display:flex;gap:8px;
  font-size:12px;color:var(--body);margin-bottom:5px;
}
.p-card .il .lk{
  color:var(--muted);font-weight:500;
  min-width:62px;flex-shrink:0;
}
.p-card .tag{
  display:inline-flex;align-items:center;gap:5px;
  background:var(--green-lt);color:var(--green);
  border:1px solid #A7F3D0;
  border-radius:6px;padding:3px 10px;
  font-size:11px;font-weight:700;margin-top:8px;
}

/* ── ITEMS TABLE ── */
.items-wrap{
  background:var(--white);
  border:1px solid var(--border);
  border-radius:14px;overflow:hidden;
  margin-bottom:28px;
}
.items-table{width:100%;border-collapse:collapse;}
.items-table thead tr{
  background:linear-gradient(90deg,var(--brand),#2D8BFF);
}
.items-table thead th{
  padding:13px 18px;text-align:left;
  font-size:11px;font-weight:700;
  letter-spacing:.8px;text-transform:uppercase;color:#fff;
}
.items-table tbody tr{border-bottom:1px solid var(--border);}
.items-table tbody tr:last-child{border-bottom:none;}
.items-table tbody tr:nth-child(even){background:#F8FAFF;}
.items-table tbody td{
  padding:13px 18px;font-size:12.5px;
  color:var(--dark);vertical-align:middle;
}
.pkg-badge{
  display:inline-flex;align-items:center;gap:6px;
  padding:4px 14px;border-radius:20px;
  font-size:11.5px;font-weight:700;color:#fff;
}
.pkg-badge.gold{background:linear-gradient(135deg,#D97706,#F59E0B);}
.pkg-badge.diamond{background:linear-gradient(135deg,#0284C7,#38BDF8);}
.pkg-badge.platinum{background:linear-gradient(135deg,#6D28D9,#A78BFA);}
.pkg-badge.default{background:linear-gradient(135deg,var(--brand),#2D8BFF);}

.items-table .sub-row td{color:var(--muted);font-size:12px;}
.items-table .total-row td{
  background:linear-gradient(90deg,var(--brand),#2D8BFF);
  color:#fff;font-weight:700;font-size:13.5px;
}
.items-table .words-row td{
  background:var(--amber-lt);
  border-top:2px solid #FDE68A;
  font-size:12px;color:#92400E;font-weight:500;
}

/* ── PAY GRID ── */
.pay-grid{
  display:grid;grid-template-columns:1fr 1fr;
  gap:20px;margin-bottom:28px;
}
.pay-card{
  background:var(--bg);
  border:1px solid var(--border);
  border-radius:14px;overflow:hidden;
}
.pay-card .ph{
  background:linear-gradient(90deg,var(--brand-lt),#F8FAFF);
  border-bottom:1px solid var(--border);
  padding:10px 18px;
  font-size:10.5px;font-weight:800;
  letter-spacing:1.5px;text-transform:uppercase;
  color:var(--brand);
}
.pay-card table{width:100%;border-collapse:collapse;}
.pay-card table tr:not(:last-child) td,
.pay-card table tr:not(:last-child) th{border-bottom:1px solid var(--border);}
.pay-card table th{
  padding:10px 18px;font-weight:600;
  color:var(--muted);font-size:11.5px;
  text-align:left;width:50%;
}
.pay-card table td{
  padding:10px 18px;font-weight:600;
  color:var(--dark);font-size:12px;
}
.pay-card .total-cell{
  color:var(--brand);font-weight:800;font-size:14px;
}

/* ── SIG ROW ── */
.sig-row{
  display:flex;align-items:flex-end;
  justify-content:space-between;gap:20px;
  background:var(--bg);
  border:1px solid var(--border);
  border-radius:14px;
  padding:20px 24px;margin-bottom:28px;
}
.sig-note{
  font-size:11.5px;color:var(--muted);
  display:flex;align-items:flex-start;gap:8px;
}
.sig-note .ni{font-size:16px;margin-top:1px;flex-shrink:0;}
.sig-box{text-align:center;min-width:180px;}
.sig-line{
  width:180px;height:1px;
  background:var(--dark);
  margin:0 auto 6px;
}
.sig-label{
  font-size:11px;font-weight:700;
  letter-spacing:1px;text-transform:uppercase;
  color:var(--muted);
}
.sig-name{font-size:12px;font-weight:600;color:var(--dark);margin-top:2px;}

/* ══ FOOTER ══ */
.inv-footer{
  background:linear-gradient(135deg,var(--dark),#1A2463);
  color:#fff;padding:28px 40px;
}
.footer-inner{
  display:flex;align-items:center;
  justify-content:space-between;gap:20px;
  margin-bottom:16px;
}
.fo-office{font-size:11.5px;opacity:.65;line-height:1.75;}
.fo-office strong{opacity:1;color:#fff;}
.fo-office a{color:rgba(255,255,255,.7);text-decoration:none;}
.fo-thank .ty{
  font-family:'Playfair Display',serif;
  font-size:24px;font-weight:800;
}
.fo-thank .team{font-size:11px;opacity:.6;margin-top:3px;}
.fo-divider{height:1px;background:rgba(255,255,255,.1);margin-bottom:14px;}
.footer-bot{
  display:flex;align-items:center;
  justify-content:space-between;gap:20px;
}
.gen-note{font-size:11px;opacity:.5;display:flex;align-items:center;gap:6px;}
.print-btn{
  background:rgba(255,255,255,.12);
  border:1px solid rgba(255,255,255,.2);
  color:#fff;padding:8px 20px;
  border-radius:8px;font-size:12px;font-weight:600;
  cursor:pointer;transition:background .2s;
  font-family:'Inter',sans-serif;
}
.print-btn:hover{background:rgba(255,255,255,.22);}

/* ══ PRINT ══ */
@media print{
  body{background:#fff;}
  .inv-wrap{box-shadow:none;margin:0;border-radius:0;}
  .print-btn{display:none;}
  .inv-header,.reg-bar,.inv-footer,
  .items-table thead tr,
  .items-table .total-row td,
  .p-card .ph,.pay-card .ph{
    -webkit-print-color-adjust:exact;
    print-color-adjust:exact;
  }
}

/* ══ RESPONSIVE / EMAIL CLIENT ══ */
@media screen and (max-width:620px){
  .inv-wrap{margin:0;border-radius:0;}
  .header-inner{flex-direction:column;}
  .h-right{min-width:auto;border-left:none;border-top:1px solid rgba(255,255,255,.1);}
  .parties-grid,.pay-grid{grid-template-columns:1fr;}
  .sig-row{flex-direction:column;align-items:flex-start;}
  .footer-inner,.footer-bot{flex-direction:column;text-align:center;}
  .fo-thank{text-align:center;}
  .reg-bar{gap:14px;padding:10px 20px;}
  .inv-body{padding:24px 20px;}
  .h-left,.h-right{padding:24px 20px;}
}
</style>
</head>
<body>

<div class="inv-wrap">

  <!-- ══ HEADER ══ -->
  <div class="inv-header">
    <div class="header-inner">

      <div class="h-left">
        <img src="https://www.quickdials.com/client/images/small-logo.png" alt="Quick Dials">
        <div class="co-name">Quick Dials Pvt. Ltd.</div>
        <div class="co-info">
          G-13, Third Floor, Sector-3, Noida, U.P. India — 201301<br>
          📞 +91-75-9543-9543 &nbsp;|&nbsp;
          ✉ <a href="mailto:info@quickdials.com">info@quickdials.com</a><br>
          🌐 <a href="https://www.quickdials.com" target="_blank">www.quickdials.com</a>
        </div>
      </div>

      <div class="h-right">
        <div class="doc-lbl">Document Type</div>
        <div class="doc-type">E-Invoice</div>
        
        <div class="mr">
          <span class="mk">Invoice Date</span>
          <span class="mv"><?php echo date('d M Y', strtotime($paymentprint->order_date)); ?></span>
        </div>
        <div class="mr">
          <span class="mk">Generated On</span>
          <span class="mv"><?php echo date('d M Y'); ?></span>
        </div>
      </div>

    </div>
  </div>

  <!-- ── REG BAR ── -->
  <div class="reg-bar">
    <div class="reg-item">🏢 GSTIN: <strong>09AAECL0574H1ZG</strong></div>
    <div class="reg-item">📋 PAN: <strong>AABCQ2259D</strong></div>
    <div class="reg-item">🏦 TAN: <strong>BLRQ01951F</strong></div>
    <div class="reg-item">🔖 CIN: <strong>U63112KA2026PTC215594</strong></div>
  </div>

  <!-- ══ BODY ══ -->
  <div class="inv-body">

    <!-- Party Details -->
    <div class="sec-title"><span class="si">👥</span> Party Details</div>
    <div class="parties-grid">

      <!-- Receiver -->
      <div class="p-card">
        <div class="ph">📄 Details of Receiver (Billed To)</div>
        <div class="pb">
          <div class="biz"><?php echo ucwords($client->business_name); ?></div>
          <div class="il"><span class="lk">Phone</span><span><?php echo $client->mobile ?? 'N/A'; ?></span></div>
          <div class="il"><span class="lk">Email</span><span><?php echo $client->email ?? 'N/A'; ?></span></div>
          <div class="il"><span class="lk">PAN No</span><span><?php echo $client->pan_no ?? 'N/A'; ?></span></div>
          <div class="il"><span class="lk">GST No</span><span><?php echo $client->gst_no ?? 'N/A'; ?></span></div>
          <?php if(!empty($client->gst_no)): ?>
          <div class="tag">✅ GST Verified</div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Address -->
      <div class="p-card">
        <div class="ph">🚚 Billing Address</div>
        <div class="pb">
          <div class="biz">
            <?php echo ($client->sirName ?? '').' '.($client->first_name ?? '').' '.($client->last_name ?? ''); ?>
          </div>
          <div class="il"><span class="lk">Address</span><span><?php echo $client->address ?? 'N/A'; ?></span></div>
          <?php if(!empty($client->city)): ?>
          <div class="il"><span class="lk">City</span><span><?php echo $client->city; ?></span></div>
          <?php endif; ?>
          <div class="il"><span class="lk">GSTIN</span><span><?php echo $client->gst_no ?? 'N/A'; ?></span></div>
        </div>
      </div>

    </div>

    <!-- Items -->
    <div class="sec-title"><span class="si">📦</span> Invoice Items</div>
    <div class="items-wrap">
      <table class="items-table">
        <thead>
          <tr>
            <th style="width:50px;">S.No</th>
            <th>Package</th>
            <th></th>
            <th style="text-align:right;">Rate (Per Package)</th>
            <th style="text-align:right;">Amount</th>
          </tr>
        </thead>
        <tbody>

          <!-- Package Row -->
          <tr>
            <td style="color:var(--muted);font-weight:600;">01</td>
            <td>
              <?php
                $pkg = strtolower($paymentprint->package_name ?? '');
                $icons = ['gold'=>'⭐','diamond'=>'💎','platinum'=>'👑'];
                $icon  = $icons[$pkg] ?? '📦';
                $label = ucfirst($pkg);
              ?>
              <span class="pkg-badge <?php echo in_array($pkg,['gold','diamond','platinum']) ? $pkg : 'default'; ?>">
                <?php echo $icon.' '.$label; ?>
              </span>
            </td>
            <td>
               
            </td>
            <td style="text-align:right;">₹ <?php echo number_format($paymentprint->paid_amount, 2); ?></td>
            <td style="text-align:right;font-weight:700;">₹ <?php echo number_format($paymentprint->paid_amount, 2); ?></td>
          </tr>

          <!-- GST -->
          <tr class="sub-row">
            <td colspan="3"></td>
            <td style="text-align:right;font-weight:600;color:var(--body);">GST</td>
            <td style="text-align:right;font-weight:600;">₹ <?php echo number_format($paymentprint->gst_tax, 2); ?> INR</td>
          </tr>

          <!-- TDS -->
          <tr class="sub-row">
            <td colspan="3"></td>
            <td style="text-align:right;font-weight:600;color:var(--body);">TDS (@2%)</td>
            <td style="text-align:right;font-weight:600;">₹ <?php echo number_format($paymentprint->tds_amount, 2); ?> INR</td>
          </tr>

          <!-- Total -->
          <tr class="total-row">
            <td colspan="3"></td>
            <td style="text-align:right;">Total Amount</td>
            <td style="text-align:right;">₹ <?php echo number_format($paymentprint->total_amount, 2); ?> INR</td>
          </tr>

          <!-- Words -->
          <tr class="words-row">
            <td colspan="2" style="font-weight:700;">💬 Invoice Value (In Words)</td>
            <td colspan="3">
              <strong>Rs. <?php echo number_format($paymentprint->total_amount, 2); ?> INR</strong><br>
              <span style="font-size:11.5px;"><?php echo $paymentprint->paid_amt_in_words; ?></span>
            </td>
          </tr>

        </tbody>
      </table>
    </div>

    <!-- Payment Details -->
    <div class="sec-title"><span class="si">💳</span> Payment Details</div>
    <div class="pay-grid">

      <div class="pay-card">
        <div class="ph">🏦 Transaction Info</div>
        <table>
          <tr>
            <th>Mode of Payment</th>
            <td>
              <?php
                echo ucfirst($paymentprint->payment_mode ?? 'NA');
                if(!empty($paymentprint->payment_bank))        echo ' / '.ucfirst($paymentprint->payment_bank);
                elseif(!empty($paymentprint->chq_card_no))     echo ' / Cheque: '.$paymentprint->chq_card_no;
                elseif(!empty($paymentprint->pay_paytm))       echo ' / Paytm: '.$paymentprint->pay_paytm;
                elseif(!empty($paymentprint->pay_neft))        echo ' / NEFT: '.$paymentprint->pay_neft;
                elseif(!empty($paymentprint->pay_googlePay))   echo ' / GPay: '.$paymentprint->pay_googlePay;
              ?>
            </td>
          </tr>
          <tr>
            <th>Payment Date</th>
            <td><?php echo date('d M Y', strtotime($paymentprint->created_at)); ?></td>
          </tr>
          <?php if(!empty($paymentprint->transactionid)): ?>
          <tr>
            <th>Transaction ID</th>
            <td>#<?php echo $paymentprint->transactionid; ?></td>
          </tr>
          <?php endif; ?>
          <?php if(!empty($paymentprint->chq_card_no)): ?>
          <tr>
            <th>Cheque No</th>
            <td><?php echo $paymentprint->chq_card_no; ?></td>
          </tr>
          <?php endif; ?>
        </table>
      </div>

      <div class="pay-card">
        <div class="ph">📊 Amount Summary</div>
        <table>
          <tr>
            <th>GST Amount</th>
            <td>₹ <?php echo number_format($paymentprint->gst_tax, 2); ?> INR</td>
          </tr>
          <tr>
            <th>TDS Amount</th>
            <td>₹ <?php echo number_format($paymentprint->tds_amount, 2); ?> INR</td>
          </tr>
          <tr>
            <th>Total Amount</th>
            <td class="total-cell">₹ <?php echo number_format($paymentprint->total_amount, 2); ?> INR</td>
          </tr>
        </table>
      </div>

    </div>

    <!-- Signature -->
    <div class="sig-row">
      <div class="sig-note">
        <span class="ni">ℹ️</span>
        <span>
          This is a <strong>system generated E-Invoice</strong> and hence no physical signature is required.
          This document is legally valid without a manual signature as per IT Act 2000.
        </span>
      </div>
      <div class="sig-box">
        <div class="sig-line"></div>
        <div class="sig-label">Authorised Signatory</div>
        <div class="sig-name">Quick Dials Pvt. Ltd.</div>
      </div>
    </div>

  </div><!-- /inv-body -->

  <!-- ══ FOOTER ══ -->
  <div class="inv-footer">
    <div class="footer-inner">
      <div class="fo-office">
        <strong>Registered Office:</strong><br>
        G-13, Sector-3, Noida, Pin Code — 201301 (UP), India<br>
        <span style="font-size:10.5px;">
          Support: <a href="https://www.quickdials.com/contact-us" target="_blank">help@quickdials.com</a>
          &nbsp;|&nbsp; Helpline: +91-75-9543-9543 &nbsp;|&nbsp;
        </span>
      </div>
      <div class="fo-thank">
        <div class="ty">Thank You!</div>
        <div class="team">Team Quick Dials Pvt. Ltd.</div>
      </div>
    </div>
    <div class="fo-divider"></div>
    <div class="footer-bot">
      <div class="gen-note">
       
      </div>
      <button class="print-btn" onclick="window.print()">🖨️ Print Invoice</button>
    </div>
  </div>

</div><!-- /inv-wrap -->

</body>
</html>
