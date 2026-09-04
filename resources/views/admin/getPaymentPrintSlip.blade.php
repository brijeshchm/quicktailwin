<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>QuickDials — Order <?php echo date('d-m-Y H:i:s'); ?></title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap');

  :root {
    --brand:     #005DFF;
    --brand-dk:  #003DB3;
    --accent:    #FF6B2B;
    --dark:      #0A0F28;
    --mid:       #4B5563;
    --light:     #F4F7FF;
    --border:    #E5EAF3;
    --success:   #10B981;
    --white:     #FFFFFF;
  }

  * { margin:0; padding:0; box-sizing:border-box; }

  body {
    font-family: 'Inter', sans-serif;
    background: #EEF2FF;
    color: var(--dark);
    font-size: 13px;
    line-height: 1.6;
  }

  /* ── PAGE WRAPPER ── */
  .page {
    max-width: 820px;
    margin: 30px auto;
    background: var(--white);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,93,255,.12);
  }

  /* ── HEADER ── */
  .inv-header {
    background: linear-gradient(135deg, var(--brand-dk) 0%, var(--brand) 60%, #3B82F6 100%);
    padding: 36px 40px 28px;
    color: var(--white);
    position: relative;
    overflow: hidden;
  }
  .inv-header::before {
    content:'';
    position:absolute;
    top:-60px; right:-60px;
    width:220px; height:220px;
    border-radius:50%;
    background:rgba(255,255,255,.07);
  }
  .inv-header::after {
    content:'';
    position:absolute;
    bottom:-80px; right:80px;
    width:160px; height:160px;
    border-radius:50%;
    background:rgba(255,255,255,.05);
  }

  .header-top {
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:20px;
  }

  .brand-block { flex:1; }
  .brand-block img {
    height:44px;     
    margin-bottom:12px;
    display:block;
  }
  .brand-block h1 {
    font-family:'Playfair Display',serif;
    font-size:22px;
    font-weight:700;
    letter-spacing:-.3px;
    line-height:1.2;
  }
  .brand-block p {
    font-size:11.5px;
    opacity:.8;
    margin-top:4px;
    line-height:1.7;
  }

  .invoice-badge {
    text-align:right;
    flex-shrink:0;
  }
  .invoice-badge .label {
    font-size:11px;
    font-weight:600;
    letter-spacing:2px;
    text-transform:uppercase;
    opacity:.75;
  }
  .invoice-badge .number {
    font-size:28px;
    font-weight:700;
    letter-spacing:-1px;
    line-height:1;
    margin-top:4px;
  }
  .invoice-badge .date-tag {
    margin-top:8px;
    display:inline-block;
    background:rgba(255,255,255,.18);
    border:1px solid rgba(255,255,255,.25);
    border-radius:20px;
    padding:4px 12px;
    font-size:11px;
    font-weight:500;
  }

  /* ── GREETING STRIP ── */
  .greeting-strip {
    background: var(--light);
    border-bottom: 1px solid var(--border);
    padding: 14px 40px;
    display:flex;
    align-items:center;
    gap:10px;
    font-size:13px;
    color: var(--mid);
  }
  .greeting-strip strong { color: var(--dark); }
  .greeting-strip .dot {
    width:6px; height:6px;
    border-radius:50%;
    background:var(--brand);
    flex-shrink:0;
  }

  /* ── BODY SECTIONS ── */
  .inv-body { padding: 32px 40px; }

  .section-title {
    display:flex;
    align-items:center;
    gap:8px;
    font-size:11px;
    font-weight:700;
    letter-spacing:1.5px;
    text-transform:uppercase;
    color: var(--brand);
    margin-bottom:14px;
  }
  .section-title::after {
    content:'';
    flex:1;
    height:1px;
    background: linear-gradient(90deg, var(--border), transparent);
  }

  /* ── TWO-COL GRID ── */
  .two-col { display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:28px; }

  /* ── INFO CARD ── */
  .info-card {
    background: var(--light);
    border: 1px solid var(--border);
    border-radius:12px;
    overflow:hidden;
  }
  .info-card .card-head {
    background: linear-gradient(90deg,#EEF2FF,#F8FAFF);
    border-bottom:1px solid var(--border);
    padding:10px 16px;
    font-size:11px;
    font-weight:700;
    letter-spacing:1px;
    text-transform:uppercase;
    color:var(--brand);
  }
  .info-card table { width:100%; border-collapse:collapse; }
  .info-card table tr:not(:last-child) td,
  .info-card table tr:not(:last-child) th {
    border-bottom:1px solid var(--border);
  }
  .info-card table th {
    padding:9px 16px;
    font-weight:600;
    color:var(--mid);
    font-size:11.5px;
    white-space:nowrap;
    width:45%;
    text-align:left;
    background:transparent;
  }
  .info-card table td {
    padding:9px 16px;
    font-weight:500;
    color:var(--dark);
    font-size:12px;
  }

  /* ── FULL-WIDTH TABLE ── */
  .full-card {
    background:var(--white);
    border:1px solid var(--border);
    border-radius:12px;
    overflow:hidden;
    margin-bottom:28px;
  }
  .full-card .card-head {
    background: linear-gradient(90deg,#EEF2FF,#F8FAFF);
    border-bottom:1px solid var(--border);
    padding:10px 20px;
    font-size:11px;
    font-weight:700;
    letter-spacing:1px;
    text-transform:uppercase;
    color:var(--brand);
  }

  /* ── PAYMENT TABLE ── */
  .pay-grid {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:24px;
    margin-bottom:28px;
  }

  .pay-summary {
    background:var(--light);
    border:1px solid var(--border);
    border-radius:12px;
    overflow:hidden;
  }
  .pay-summary .card-head {
    background:linear-gradient(90deg,#EEF2FF,#F8FAFF);
    border-bottom:1px solid var(--border);
    padding:10px 16px;
    font-size:11px;
    font-weight:700;
    letter-spacing:1px;
    text-transform:uppercase;
    color:var(--brand);
  }
  .pay-summary table { width:100%; border-collapse:collapse; }
  .pay-summary table tr:not(:last-child) td,
  .pay-summary table tr:not(:last-child) th {
    border-bottom:1px solid var(--border);
  }
  .pay-summary table th {
    padding:9px 16px;
    font-weight:600;
    color:var(--mid);
    font-size:11.5px;
    text-align:left;
    width:55%;
  }
  .pay-summary table td {
    padding:9px 16px;
    font-weight:600;
    color:var(--dark);
    font-size:12px;
    text-align:right;
  }
  .pay-summary .total-row th,
  .pay-summary .total-row td {
    background:var(--brand);
    color:var(--white) !important;
    font-size:13px;
    font-weight:700;
  }

  /* ── LISTING TABLE ── */
  .listing-table { width:100%; border-collapse:collapse; }
  .listing-table thead tr {
    background:linear-gradient(90deg,var(--brand),#3B82F6);
    color:var(--white);
  }
  .listing-table thead th {
    padding:11px 20px;
    font-size:11.5px;
    font-weight:600;
    letter-spacing:.5px;
    text-align:left;
  }
  .listing-table tbody tr:nth-child(even) { background:#F8FAFF; }
  .listing-table tbody tr:hover { background:#EEF2FF; }
  .listing-table tbody td {
    padding:10px 20px;
    font-size:12px;
    color:var(--dark);
    border-bottom:1px solid var(--border);
  }

  /* ── NOTES ── */
  .notes-box {
    background:#FFFBEB;
    border:1px solid #FDE68A;
    border-left:4px solid #F59E0B;
    border-radius:10px;
    padding:16px 20px;
    margin-bottom:28px;
  }
  .notes-box .notes-title {
    font-size:11px;
    font-weight:700;
    letter-spacing:1px;
    text-transform:uppercase;
    color:#92400E;
    margin-bottom:10px;
    display:flex;
    align-items:center;
    gap:6px;
  }
  .notes-box ul {
    list-style:none;
    display:flex;
    flex-direction:column;
    gap:5px;
  }
  .notes-box ul li {
    font-size:11.5px;
    color:#78350F;
    padding-left:14px;
    position:relative;
    line-height:1.6;
  }
  .notes-box ul li::before {
    content:'→';
    position:absolute;
    left:0;
    color:#F59E0B;
    font-size:10px;
  }

  /* ── FOOTER ── */
  .inv-footer {
    background:linear-gradient(135deg,var(--dark),#1E2A5A);
    color:var(--white);
    padding:28px 40px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
  }
  .footer-left .tc-link {
    color:#93C5FD;
    text-decoration:none;
    font-size:12px;
    font-weight:600;
  }
  .footer-left p {
    font-size:11px;
    opacity:.6;
    margin-top:4px;
  }
  .thank-block {
    text-align:right;
  }
  .thank-block .thank-text {
    font-family:'Playfair Display',serif;
    font-size:22px;
    font-weight:700;
    color:var(--white);
    letter-spacing:-.3px;
  }
  .thank-block .team-text {
    font-size:11px;
    opacity:.65;
    margin-top:3px;
  }
  .regd-office {
    font-size:10.5px;
    opacity:.5;
    margin-top:6px;
    max-width:360px;
    line-height:1.5;
  }

  /* ── PRINT ── */
  @media print {
    body { background:var(--white); }
    .page { box-shadow:none; margin:0; border-radius:0; }
    .notes-box { -webkit-print-color-adjust:exact; print-color-adjust:exact; }
    .inv-header, .inv-footer,
    .listing-table thead tr,
    .pay-summary .total-row th,
    .pay-summary .total-row td { -webkit-print-color-adjust:exact; print-color-adjust:exact; }
  }
</style>
</head>
<body>

<div class="page">

  <!-- ══ HEADER ══ -->
  <div class="inv-header">
    <div class="header-top">
      <div class="brand-block">
        <img src="https://www.quickdials.com/client/images/small-logo.png" alt="QuickDials">
        <h1>QuickDials Internet Pvt. Ltd.</h1>
        <p>
          UNIT 101 OXFORD TOWERS, 139/88 HAL OLD AIRPORT RD, H.A.L II Stage, Bangalore North, Bangalore- 560008<br>
          📞 +91-75-5943-5943 &nbsp;|&nbsp; ✉ info@quickdials.com &nbsp;|&nbsp; 🌐 www.quickdials.com
        </p>
      </div>
      <div class="invoice-badge">
        <div class="label">Order Receipt</div>
        <div class="number">#<?php echo $paymentuprint->order_number ?></div>
        <div class="date-tag">📅 <?php echo date('d M Y', strtotime($paymentuprint->order_date)); ?></div>
      </div>
    </div>
  </div>

  <!-- ══ GREETING ══ -->
  <div class="greeting-strip">
    <div class="dot"></div>
    Dear <strong>&nbsp;<?php echo $paymentuprint->business_name ?></strong>, &nbsp;— Thank you for choosing QuickDials!.
  </div>

  <!-- ══ BODY ══ -->
  <div class="inv-body">

    <!-- Order + Customer Details -->
    <div class="section-title">Order Information</div>
    <div class="two-col">

      <div class="info-card">
        <div class="card-head">📋 Order Details</div>
        <table>
          <tr><th>Order Number</th><td>#<?php echo $paymentuprint->order_number ?></td></tr>
          <tr><th>Order Date</th><td><?php echo date('d M Y', strtotime($paymentuprint->order_date)); ?></td></tr>
          <tr><th>Package</th><td><?php echo $paymentuprint->package_name ?></td></tr>
          <tr><th>Leads</th><td><?php echo $paymentuprint->leads_count ?></td></tr>
          <?php if(!empty($paymentuprint->expired_from)): ?>
          <tr><th>Duration</th><td><?php echo date('d M Y',strtotime($paymentuprint->expired_from)); ?> → <?php echo date('d M Y',strtotime($paymentuprint->expired_on)); ?></td></tr>
          <?php endif; ?>
        </table>
      </div>

      <div class="info-card">
        <div class="card-head">👤 Customer Details</div>
        <table>
          <tr><th>Customer Name</th><td><?php echo ucfirst($paymentuprint->customer_name) ?></td></tr>
          <tr><th>Business Name</th><td><?php echo ucfirst($paymentuprint->business_name) ?></td></tr>
          <tr><th>Phone</th><td><?php echo $paymentuprint->mobile ?></td></tr>
          <?php if(!empty($paymentuprint->comment_author_email)): ?>
          <tr><th>Email</th><td><?php echo $paymentuprint->comment_author_email ?></td></tr>
          <?php endif; ?>
        </table>
      </div>

    </div>

    <!-- Payment Details -->
    <div class="section-title">Payment Details</div>
    <div class="pay-grid">

      <div class="pay-summary">
        <div class="card-head">💰 Amount Summary</div>
        <table>
          <tr><th>Amount Paid</th><td>₹ <?php echo number_format($paymentuprint->paid_amount, 2) ?></td></tr>
          <tr><th>GST</th><td>₹ <?php echo number_format($paymentuprint->gst_tax, 2) ?></td></tr>
          <tr><th>TDS</th><td>₹ <?php echo number_format($paymentuprint->tds_amount, 2) ?></td></tr>
          <tr class="total-row"><th>Total Amount</th><td>₹ <?php echo number_format($paymentuprint->total_amount, 2) ?></td></tr>
        </table>
      </div>

      <div class="pay-summary">
        <div class="card-head">🏦 Payment Info</div>
        <table>
          <tr>
            <th>Mode</th>
            <td><?php echo ucfirst($paymentuprint->payment_mode); ?></td>
          </tr>
          <tr>
            <th>Bank / Ref</th>
            <td>
              <?php
                if(!empty($paymentuprint->payment_bank)) echo ucfirst($paymentuprint->payment_bank);
                elseif(!empty($paymentuprint->chq_card_no)) echo 'Cheque: '.$paymentuprint->chq_card_no;
                elseif(!empty($paymentuprint->pay_paytm)) echo $paymentuprint->pay_paytm;
                elseif(!empty($paymentuprint->pay_neft)) echo $paymentuprint->pay_neft;
                elseif(!empty($paymentuprint->pay_googlePay)) echo $paymentuprint->pay_googlePay;
                else echo '—';
              ?>
            </td>
          </tr>
          <?php if(!empty($paymentuprint->transactionid)): ?>
          <tr><th>Transaction ID</th><td>#<?php echo $paymentuprint->transactionid ?></td></tr>
          <?php endif; ?>
          <tr><th>Amount in Words</th><td><?php echo $paymentuprint->paid_amt_in_words ?></td></tr>
          <?php if($paymentuprint->proofid): ?>
          <tr><th>ID Proof</th><td><?php echo $paymentuprint->selectproofid ?> (<?php echo $paymentuprint->proofid ?>)</td></tr>
          <?php endif; ?>
        </table>
      </div>

    </div>

    <!-- Listing Details -->
    <?php if(!empty($assignKeyword)): ?>
    <div class="section-title">Listing Details</div>
    <div class="full-card" style="margin-bottom:28px;">
      <table class="listing-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Category</th>
            <th>Keyword</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; foreach($assignKeyword as $keyword): ?>
          <tr>
            <td style="color:var(--mid);width:40px;"><?php echo $i++; ?></td>
            <td><?php echo $keyword->parent_category; ?></td>
            <td><?php echo $keyword->keyword; ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>

    <!-- Notes -->
    <div class="notes-box">
      <div class="notes-title">⚠ Important Notes</div>
      <ul>
        <li>You can check your balance value and pending lead details after logging into quickdials.com.</li>
        <li>No verbal or written commitment outside this order form will be considered.</li>
        <li>This contract represents the entire agreement between the parties and supersedes any other terms.</li>
        <li>Your advertisement will be activated within <strong>3 days</strong> of payment clearance.</li>
        <li>Applicable TDS rate is <strong>@2%</strong> under Section 194C on net amount excluding tax.</li>
        <li>For queries, email us at <a href="mailto:help@quickdials.com" style="color:#92400E;font-weight:600;">help@quickdials.com</a></li>
        <li>Timings: Monday to Sunday — 24/7</li>
      </ul>
    </div>

    <!-- GST / TAN -->
    <div class="info-card" style="margin-bottom:0;">
      <div class="card-head">🏢 Company Registration</div>
      <table>
        <tr>
          <th>GST Number</th>
          <td>09AAECL0574H1ZG</td>
          <th>TAN Number</th>
          <td>BLRQ01951F</td>
        </tr>
		 <tr>
          <th>PAN No</th>
          <td>AABCQ2259D</td>
          <th>CIN No</th>
          <td>U63112KA2026PTC215594</td>
        </tr>
      </table>
    </div>

  </div><!-- /inv-body -->

  <!-- ══ FOOTER ══ -->
  <div class="inv-footer">
    <div class="footer-left">
      <a href="https://www.quickdials.com/privacy-policy" target="_blank" class="tc-link">
        Terms &amp; Conditions →
      </a>
      <p>Looking forward to a long and fruitful association with you!</p>
      <p class="regd-office">
        Regd. Office: Unit 101, Oxford Towers, 139/88 HAL Old Airport Rd, H.A.L II Stage, Bangalore North, Bangalore — 560008, Karnataka.
      </p>
    </div>
    <div class="thank-block">
      <div class="thank-text">Thank You!</div>
      <div class="team-text">Team QuickDials Internet Pvt. Ltd.</div>
    </div>
  </div>

</div><!-- /page -->

</body>
</html>
