<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QuickDials — Proforma Invoice <?php echo date('d-m-Y H:i:s'); ?></title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap');

/* ── RESET ── */
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

:root {
  --brand:      #005DFF;
  --brand-dk:   #0042CC;
  --brand-lt:   #EEF4FF;
  --accent:     #FF6B2B;
  --green:      #10B981;
  --dark:       #0D1340;
  --body:       #374151;
  --muted:      #6B7280;
  --border:     #E5EAF3;
  --bg:         #F4F7FF;
  --white:      #FFFFFF;
  --gold:       #F59E0B;
}

body {
  font-family: 'Inter', Arial, sans-serif;
  background: var(--bg);
  color: var(--body);
  font-size: 13px;
  line-height: 1.6;
  -webkit-font-smoothing: antialiased;
}

/* ── WRAPPER ── */
.invoice-wrap {
  max-width: 860px;
  margin: 30px auto;
  background: var(--white);
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 24px 80px rgba(0,93,255,.13);
}

/* ══════════════════════════════
   HEADER
══════════════════════════════ */
.inv-header {
  background: linear-gradient(135deg, #001F8C 0%, #005DFF 55%, #2D8BFF 100%);
  padding: 0;
  position: relative;
  overflow: hidden;
}
.inv-header::before {
  content:'';
  position:absolute; top:-80px; right:-80px;
  width:260px; height:260px; border-radius:50%;
  background: rgba(255,255,255,.06);
}
.inv-header::after {
  content:'';
  position:absolute; bottom:-100px; left:40%;
  width:200px; height:200px; border-radius:50%;
  background: rgba(255,255,255,.04);
}

.header-inner {
  display: flex;
  align-items: stretch;
  position: relative;
  z-index: 1;
}

.header-left {
  flex: 1;
  padding: 36px 40px;
  color: var(--white);
}
.header-left .logo {
  height: 46px;  
  margin-bottom: 14px;
  display: block;
}
.header-left .company-name {
  font-family: 'Playfair Display', serif;
  font-size: 20px;
  font-weight: 800;
  letter-spacing: -.3px;
  margin-bottom: 8px;
}
.header-left .company-info {
  font-size: 11.5px;
  opacity: .78;
  line-height: 1.8;
}
.header-left .company-info a {
  color: rgba(255,255,255,.85);
  text-decoration: none;
}

.header-right {
  background: rgba(0,0,0,.18);
  backdrop-filter: blur(10px);
  padding: 36px 36px;
  min-width: 220px;
  color: var(--white);
  display: flex;
  flex-direction: column;
  justify-content: center;
  border-left: 1px solid rgba(255,255,255,.1);
}
.header-right .inv-label {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  opacity: .65;
  margin-bottom: 6px;
}
.header-right .inv-type {
  font-family: 'Playfair Display', serif;
  font-size: 26px;
  font-weight: 800;
  line-height: 1.1;
  margin-bottom: 18px;
}
.header-right .meta-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 7px 0;
  border-bottom: 1px solid rgba(255,255,255,.1);
  font-size: 11.5px;
}
.header-right .meta-row:last-child { border-bottom: none; }
.header-right .meta-row .mk { opacity:.6; font-weight:500; }
.header-right .meta-row .mv { font-weight:700; }

/* ── REG NUMBERS BAR ── */
.reg-bar {
  background: #001F8C;
  padding: 10px 40px;
  display: flex;
  gap: 32px;
  flex-wrap: wrap;
}
.reg-item {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 11px;
  color: rgba(255,255,255,.7);
}
.reg-item strong {
  color: rgba(255,255,255,.95);
  font-weight: 700;
}

/* ══════════════════════════════
   BODY
══════════════════════════════ */
.inv-body { padding: 36px 40px; }

/* Section title */
.sec-title {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 10.5px;
  font-weight: 800;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--brand);
  margin-bottom: 14px;
}
.sec-title::after {
  content:'';
  flex:1;
  height:2px;
  background: linear-gradient(90deg, var(--brand-lt), transparent);
  border-radius: 2px;
}
.sec-title .icon {
  width: 24px; height: 24px;
  background: var(--brand-lt);
  border-radius: 6px;
  display: flex; align-items: center; justify-content: center;
  font-size: 13px;
}

/* ── BILLED / SHIPPED ── */
.parties-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 32px;
}
.party-card {
  background: var(--bg);
  border: 1px solid var(--border);
  border-radius: 14px;
  overflow: hidden;
}
.party-card .pc-head {
  background: linear-gradient(90deg, var(--brand-lt), #F8FAFF);
  border-bottom: 1px solid var(--border);
  padding: 10px 18px;
  font-size: 10.5px;
  font-weight: 800;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--brand);
  display: flex;
  align-items: center;
  gap: 7px;
}
.party-card .pc-body {
  padding: 16px 18px;
}
.party-card .biz-name {
  font-size: 15px;
  font-weight: 700;
  color: var(--dark);
  margin-bottom: 10px;
}
.party-card .info-line {
  display: flex;
  gap: 8px;
  font-size: 12px;
  color: var(--body);
  margin-bottom: 5px;
}
.party-card .info-line .lk {
  color: var(--muted);
  font-weight: 500;
  min-width: 58px;
  flex-shrink: 0;
}

/* ── ITEMS TABLE ── */
.items-wrap {
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 14px;
  overflow: hidden;
  margin-bottom: 28px;
}
.items-table {
  width: 100%;
  border-collapse: collapse;
}
.items-table thead tr {
  background: linear-gradient(90deg, var(--brand), #2D8BFF);
}
.items-table thead th {
  padding: 13px 18px;
  text-align: left;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .8px;
  text-transform: uppercase;
  color: var(--white);
}
.items-table tbody tr { border-bottom: 1px solid var(--border); }
.items-table tbody tr:last-child { border-bottom: none; }
.items-table tbody tr:nth-child(even) { background: #F8FAFF; }
.items-table tbody td {
  padding: 14px 18px;
  font-size: 12.5px;
  color: var(--dark);
  vertical-align: middle;
}
.items-table .pkg-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: linear-gradient(135deg, var(--brand), #2D8BFF);
  color: var(--white);
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 11.5px;
  font-weight: 700;
}
.items-table .pkg-badge.gold   { background: linear-gradient(135deg,#D97706,#F59E0B); }
.items-table .pkg-badge.diamond{ background: linear-gradient(135deg,#0284C7,#38BDF8); }
.items-table .pkg-badge.platinum{ background: linear-gradient(135deg,#6D28D9,#A78BFA); }

/* Totals rows */
.items-table .sub-row td { color: var(--muted); font-size: 12px; }
.items-table .gst-row td { color: var(--body); }
.items-table .tds-row td { color: var(--body); }
.items-table .total-row td {
  background: linear-gradient(90deg, var(--brand), #2D8BFF);
  color: var(--white);
  font-weight: 700;
  font-size: 13.5px;
}
.items-table .words-row td {
  background: #FFFBEB;
  border-top: 2px solid #FDE68A;
  font-size: 12px;
  color: #92400E;
  font-weight: 500;
}

/* ── PAYMENT DETAILS ── */
.pay-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 28px;
}
.pay-card {
  background: var(--bg);
  border: 1px solid var(--border);
  border-radius: 14px;
  overflow: hidden;
}
.pay-card .pc-head {
  background: linear-gradient(90deg, var(--brand-lt), #F8FAFF);
  border-bottom: 1px solid var(--border);
  padding: 10px 18px;
  font-size: 10.5px;
  font-weight: 800;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--brand);
}
.pay-card table { width:100%; border-collapse:collapse; }
.pay-card table tr:not(:last-child) td,
.pay-card table tr:not(:last-child) th { border-bottom:1px solid var(--border); }
.pay-card table th {
  padding:10px 18px;
  font-weight:600;
  color:var(--muted);
  font-size:11.5px;
  text-align:left;
  width:50%;
}
.pay-card table td {
  padding:10px 18px;
  font-weight:600;
  color:var(--dark);
  font-size:12px;
}

/* ── SIGNATURE ROW ── */
.sig-row {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 20px;
  background: var(--bg);
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 20px 24px;
  margin-bottom: 28px;
}
.sig-note {
  font-size: 11.5px;
  color: var(--muted);
  display: flex;
  align-items: flex-start;
  gap: 8px;
}
.sig-note .note-icon {
  font-size: 16px;
  margin-top: 1px;
  flex-shrink: 0;
}
.sig-box {
  text-align: center;
  min-width: 180px;
}
.sig-box .sig-line {
  width: 180px;
  height: 1px;
  background: var(--dark);
  margin: 0 auto 6px;
}
.sig-box .sig-label {
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--muted);
}
.sig-box .sig-name {
  font-size: 12px;
  font-weight: 600;
  color: var(--dark);
  margin-top: 2px;
}

/* ══════════════════════════════
   FOOTER
══════════════════════════════ */
.inv-footer {
  background: linear-gradient(135deg, var(--dark), #1A2463);
  color: var(--white);
  padding: 28px 40px;
}
.footer-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  margin-bottom: 16px;
}
.footer-office {
  font-size: 11.5px;
  opacity: .65;
  line-height: 1.7;
}
.footer-office strong { opacity:1; color:var(--white); }
.footer-thank {
  text-align: right;
}
.footer-thank .ty {
  font-family: 'Playfair Display', serif;
  font-size: 24px;
  font-weight: 800;
}
.footer-thank .team {
  font-size: 11px;
  opacity: .6;
  margin-top: 3px;
}
.footer-divider {
  height: 1px;
  background: rgba(255,255,255,.1);
  margin-bottom: 14px;
}
.footer-bottom {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
}
.footer-bottom .gen-note {
  font-size: 11px;
  opacity: .5;
  display: flex;
  align-items: center;
  gap: 6px;
}
.footer-bottom .print-btn {
  background: rgba(255,255,255,.12);
  border: 1px solid rgba(255,255,255,.2);
  color: var(--white);
  padding: 8px 20px;
  border-radius: 8px;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
  transition: background .2s;
}
.footer-bottom .print-btn:hover { background:rgba(255,255,255,.2); }

/* ══════════════════════════════
   PRINT STYLES
══════════════════════════════ */
@media print {
  body { background: var(--white); }
  .invoice-wrap { box-shadow:none; margin:0; border-radius:0; }
  .footer-bottom .print-btn { display:none; }
  .inv-header, .reg-bar, .inv-footer,
  .items-table thead tr,
  .items-table .total-row td,
  .party-card .pc-head,
  .pay-card .pc-head { -webkit-print-color-adjust:exact; print-color-adjust:exact; }
}

/* ══════════════════════════════
   EMAIL CLIENT COMPAT
   (Gmail / Outlook / Apple Mail)
══════════════════════════════ */
@media screen and (max-width: 600px) {
  .invoice-wrap { margin:0; border-radius:0; }
  .header-inner { flex-direction:column; }
  .header-right { min-width:auto; border-left:none; border-top:1px solid rgba(255,255,255,.1); }
  .parties-grid,
  .pay-grid { grid-template-columns:1fr; }
  .sig-row { flex-direction:column; align-items:flex-start; }
  .footer-inner,
  .footer-bottom { flex-direction:column; text-align:center; }
  .footer-thank { text-align:center; }
  .reg-bar { gap:16px; }
  .inv-body { padding:24px 20px; }
}
</style>
</head>
<body>

<div class="invoice-wrap">

  <!-- ══ HEADER ══ -->
  <div class="inv-header">
    <div class="header-inner">

      <div class="header-left">
        <img src="https://www.quickdials.com/client/images/small-logo.png" alt="Quick Dials" class="logo">
        <div class="company-name">Quick Dials Pvt. Ltd.</div>
        <div class="company-info">
          G-13, Third Floor, Sector-3 Noida, U.P. India<br>
          📞 +91-75-9543-9543 &nbsp;|&nbsp;
          ✉ <a href="mailto:info@quickdials.com">info@quickdials.com</a> &nbsp;|&nbsp;
          🌐 <a href="https://www.quickdials.com" target="_blank">www.quickdials.com</a>
        </div>
      </div>

      <div class="header-right">
        <div class="inv-label">Document Type</div>
        <div class="inv-type">Proforma<br>Invoice</div>
        <div class="meta-row">
          <span class="mk">Date</span>
          <span class="mv"><?php echo date('d M Y', strtotime($paymentprint->order_date)); ?></span>
        </div>
        <div class="meta-row">
          <span class="mk">Generated</span>
          <span class="mv"><?php echo date('d M Y'); ?></span>
        </div>
      </div>

    </div>
  </div>

  <!-- ── REG NUMBERS ── -->
  <div class="reg-bar">
    <div class="reg-item">🏢 GSTIN: <strong>09AAECL0574H1ZG</strong></div>
    <div class="reg-item">📋 PAN: <strong>AABCQ2259D</strong></div>
    <div class="reg-item">🏦 TAN: <strong>BLRQ01951F</strong></div>
    <div class="reg-item">🔖 CIN: <strong>U63112KA2026PTC215594</strong></div>
  </div>

  <!-- ══ BODY ══ -->
  <div class="inv-body">

    <!-- Billed / Shipped -->
    <div class="sec-title"><span class="icon">👥</span> Party Details</div>
    <div class="parties-grid">

      <div class="party-card">
        <div class="pc-head">📄 Details of Receiver (Billed To)</div>
        <div class="pc-body">
          <div class="biz-name"><?php echo ucwords($client->business_name); ?></div>
          <div class="info-line"><span class="lk">Address</span><span><?php echo $client->address; ?>, <?php echo $client->city; ?></span></div>
          <div class="info-line"><span class="lk">Phone</span><span><?php echo $client->mobile; ?></span></div>
          <div class="info-line"><span class="lk">Email</span><span><?php echo $client->email; ?></span></div>
        </div>
      </div>

      <div class="party-card">
        <div class="pc-head">🚚 Details of Consignee (Shipped To)</div>
        <div class="pc-body">
          <div class="biz-name"><?php echo ucwords($client->business_name); ?></div>
          <div class="info-line"><span class="lk">Address</span><span><?php echo $client->address; ?></span></div>
          <div class="info-line"><span class="lk">Phone</span><span><?php echo $client->mobile; ?></span></div>
          <div class="info-line"><span class="lk">Email</span><span><?php echo $client->email; ?></span></div>
        </div>
      </div>

    </div>

    <!-- Items Table -->
    <div class="sec-title"><span class="icon">📦</span> Package Details</div>
    <div class="items-wrap">
      <table class="items-table">
        <thead>
          <tr>
            <th style="width:50px;">S.No</th>
            <th>Package / Lead</th>
 
            <th style="text-align:right;"></th>
            <th style="text-align:right;">Rate</th>
            <th style="text-align:right;">Amount</th>
          </tr>
        </thead>
        <tbody>
          <!-- Package Row -->
          <tr>
            <td style="color:var(--muted);font-weight:600;">01</td>
            <td>
              <?php
                $pkg = strtolower($paymentprint->package_name);
                $pkgLabel = ucfirst($pkg).' ('.$paymentprint->leads_count.' Leads)';
              ?>
              <span class="pkg-badge <?php echo $pkg; ?>">
                <?php
                  if($pkg=='gold') echo '⭐ ';
                  elseif($pkg=='diamond') echo '💎 ';
                  elseif($pkg=='platinum') echo '👑 ';
                ?>
                <?php echo $pkgLabel; ?>
              </span>
            </td>
            <td style="text-align:right;"></td>
            <td style="text-align:right;">₹ <?php echo number_format($paymentprint->paid_amount, 2); ?></td>
            <td style="text-align:right;font-weight:700;">₹ <?php echo number_format($paymentprint->paid_amount, 2); ?></td>
          </tr>

          <!-- GST -->
          <tr class="sub-row">
            <td colspan="3"></td>
            <td style="text-align:right;font-weight:600;color:var(--body);">GST</td>
            <td style="text-align:right;font-weight:600;">₹ <?php echo number_format($paymentprint->gst_tax, 2); ?></td>
          </tr>

          <!-- TDS -->
          <tr class="sub-row">
            <td colspan="3"></td>
            <td style="text-align:right;font-weight:600;color:var(--body);">TDS (@2%)</td>
            <td style="text-align:right;font-weight:600;">₹ <?php echo number_format($paymentprint->tds_amount, 2); ?></td>
          </tr>

          <!-- Total -->
          <tr class="total-row">
            <td colspan="3"></td>
            <td style="text-align:right;">Total Amount</td>
            <td style="text-align:right;">₹ <?php echo number_format($paymentprint->total_amount, 2); ?> INR</td>
          </tr>

          <!-- Words -->
          <tr class="words-row">
            <td colspan="2" style="font-weight:700;">
              💬 Invoice Value (In Words)
            </td>
            <td colspan="3">
              <strong><?php echo $paymentprint->paid_amt_in_words; ?></strong>
            </td>
          </tr>

        </tbody>
      </table>
    </div>

    <!-- Payment Details -->
    <div class="sec-title"><span class="icon">💳</span> Payment Details</div>
    <div class="pay-grid">

      <div class="pay-card">
        <div class="pc-head">🏦 Transaction Info</div>
        <table>
          <tr><th>Mode of Payment</th><td>NA</td></tr>
          <tr><th>Payment Date</th><td><?php echo date('d M Y', strtotime($paymentprint->created_at)); ?></td></tr>
          <?php if(!empty($paymentprint->transactionid)): ?>
          <tr><th>Transaction ID</th><td>#<?php echo $paymentprint->transactionid; ?></td></tr>
          <?php endif; ?>
        </table>
      </div>

      <div class="pay-card">
        <div class="pc-head">📊 Amount Breakdown</div>
        <table>
          <tr><th>GST</th><td>₹ <?php echo number_format($paymentprint->gst_tax, 2); ?> INR</td></tr>
          <tr><th>TDS</th><td>₹ <?php echo number_format($paymentprint->tds_amount, 2); ?> INR</td></tr>
          <tr><th>Total Amount</th><td style="color:var(--brand);font-weight:800;font-size:14px;">₹ <?php echo number_format($paymentprint->total_amount, 2); ?> INR</td></tr>
        </table>
      </div>

    </div>

    <!-- Signature -->
    <div class="sig-row">
      <div class="sig-note">
        <span class="note-icon">ℹ️</span>
        <span>This is a <strong>system generated invoice</strong> and hence no physical signature is required. This document is valid without a manual signature.</span>
      </div>
      <div class="sig-box">
        <div class="sig-line"></div>
        <div class="sig-label">Authorised Signatory</div>
        <div class="sig-name">Quick Dials Internet Pvt. Ltd.</div>
      </div>
    </div>

  </div><!-- /inv-body -->

  <!-- ══ FOOTER ══ -->
  <div class="inv-footer">
    <div class="footer-inner">
      <div class="footer-office">
        <strong>Registered Office:</strong><br>
        Regd. Office: Unit 101, Oxford Towers, 139/88 HAL Old Airport Rd, H.A.L II Stage, Bangalore North, Bangalore — 560008, Karnataka<br>
        <span style="opacity:.5;font-size:10.5px;">
          For support: <a href="https://www.quickdials.com/contact-us" target="_blank" style="color:rgba(255,255,255,.7);text-decoration:none;">help@quickdials.com</a>
          &nbsp;|&nbsp; Timings: 24/7
        </span>
      </div>
      <div class="footer-thank">
        <div class="ty">Thank You!</div>
        <div class="team">Team Quick Dials Internet Pvt. Ltd.</div>
      </div>
    </div>
    <div class="footer-divider"></div>
    <div class="footer-bottom">
      <div class="gen-note">
        🔒 System generated document — <?php echo date('d M Y H:i'); ?>
      </div>
      <button class="print-btn" onclick="window.print()">🖨️ Print Invoice</button>
    </div>
  </div>

</div><!-- /invoice-wrap -->

</body>
</html>
