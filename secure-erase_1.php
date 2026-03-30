<?php
require_once 'includes/config.php';
include 'includes/header.php';
?>

<div class="erase-page">

  <!-- Header -->
  <div class="erase-header">
    <h1>Secure Erase Tool</h1>
    <p>Enter your phone brand and model to get exact, step-by-step hard reset instructions built specifically for your device.</p>
  </div>

  <!-- Phone selector -->
  <div class="phone-selector-card" id="selectorCard">
    <div class="selector-grid">

      <!-- Brand -->
      <div class="selector-field">
        <label for="brandInput">Phone Brand</label>
        <div class="autocomplete-wrap">
          <input type="text" id="brandInput" placeholder="e.g. Samsung, Infinix, iPhone…"
                 autocomplete="off" spellcheck="false">
          <div class="autocomplete-list" id="brandList"></div>
        </div>
      </div>

      <!-- Model -->
      <div class="selector-field">
        <label for="modelInput">Phone Model</label>
        <div class="autocomplete-wrap">
          <input type="text" id="modelInput" placeholder="e.g. Galaxy S10, Hot 30…"
                 autocomplete="off" spellcheck="false" disabled>
          <div class="autocomplete-list" id="modelList"></div>
        </div>
      </div>

    </div>

    <button class="btn-find" id="findBtn" disabled>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
           stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
      </svg>
      Get Reset Instructions
    </button>
  </div>

  <!-- Instructions output -->
  <div class="instructions-wrap" id="instructionsWrap" style="display:none">

    <div class="device-badge" id="deviceBadge"></div>

    <!-- Warning -->
    <div class="warn-box">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
           stroke-linecap="round" stroke-linejoin="round">
        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
      </svg>
      <div>
        <strong>Before you start — do these first:</strong>
        Back up all photos, contacts and files. Remove your Google account
        (Settings → Accounts → Google → Remove). This prevents Factory Reset Protection
        locking the phone after the wipe.
      </div>
    </div>

    <!-- Two method tabs -->
    <div class="method-tabs">
      <button class="method-tab active" id="tabSettings" onclick="showMethod('settings')">
        📱 Via Settings <span class="tab-badge">Recommended</span>
      </button>
      <button class="method-tab" id="tabHardware" onclick="showMethod('hardware')">
        🔑 Via Hardware Keys <span class="tab-badge">If phone is frozen</span>
      </button>
    </div>

    <!-- Settings method -->
    <div class="method-panel" id="panelSettings">
      <div class="steps-list" id="settingsSteps"></div>
    </div>

    <!-- Hardware method -->
    <div class="method-panel" id="panelHardware" style="display:none">
      <div class="steps-list" id="hardwareSteps"></div>
    </div>

    <!-- After reset note -->
    <div class="after-note">
      <strong>After the reset completes:</strong>
      The phone will show the "Welcome" or language selection screen.
      Do not sign in with your Google account again if you are selling the device.
    </div>

    <button class="btn-reset-search" onclick="resetSearch()">
      ← Search for a different phone
    </button>
  </div>

</div>

<!-- ════════════════════════════════════════════════════
     PHONE DATABASE
     Each entry: brand → models → { settings steps, hardware steps }
════════════════════════════════════════════════════ -->
<script>
const DB = {

  // ── SAMSUNG ────────────────────────────────────────────────────────
  "Samsung": {
    models: [
      "Galaxy S10","Galaxy S10+","Galaxy S10e","Galaxy S10 5G",
      "Galaxy S20","Galaxy S20+","Galaxy S20 Ultra","Galaxy S20 FE",
      "Galaxy S21","Galaxy S21+","Galaxy S21 Ultra","Galaxy S21 FE",
      "Galaxy S22","Galaxy S22+","Galaxy S22 Ultra",
      "Galaxy S23","Galaxy S23+","Galaxy S23 Ultra",
      "Galaxy S24","Galaxy S24+","Galaxy S24 Ultra",
      "Galaxy A03","Galaxy A03s","Galaxy A03 Core",
      "Galaxy A13","Galaxy A13 5G",
      "Galaxy A14","Galaxy A14 5G",
      "Galaxy A23","Galaxy A23 5G",
      "Galaxy A24","Galaxy A33","Galaxy A34",
      "Galaxy A53","Galaxy A54","Galaxy A73",
      "Galaxy M02","Galaxy M02s","Galaxy M12",
      "Galaxy M13","Galaxy M14","Galaxy M23","Galaxy M33","Galaxy M53",
      "Galaxy J2 Core","Galaxy J4","Galaxy J4+","Galaxy J6","Galaxy J6+",
      "Galaxy Note 10","Galaxy Note 10+","Galaxy Note 20","Galaxy Note 20 Ultra",
      "Galaxy Tab A7","Galaxy Tab A8","Galaxy Tab S6","Galaxy Tab S7","Galaxy Tab S8",
    ],
    settings: {
      default: [
        "Open <strong>Settings</strong> on your phone",
        "Scroll all the way down and tap <strong>General management</strong>",
        "Tap <strong>Reset</strong>",
        "Tap <strong>Factory data reset</strong>",
        "Scroll down and read the information, then tap <strong>Reset</strong>",
        "Enter your PIN, password or pattern if asked",
        "Tap <strong>Delete all</strong> to confirm — the phone will restart and wipe itself"
      ],
      "Galaxy S10": [
        "Open <strong>Settings</strong>",
        "Scroll down and tap <strong>General management</strong>",
        "Tap <strong>Reset</strong>",
        "Tap <strong>Factory data reset</strong>",
        "Scroll to the bottom and tap <strong>Reset</strong>",
        "Enter your PIN or password if asked",
        "Tap <strong>Delete all</strong> — wipe begins, takes 2–5 minutes"
      ],
    },
    hardware: {
      default: [
        "Power off your Samsung completely",
        "Press and hold <strong>Volume Up + Power</strong> at the same time",
        "<em>For S8/S9/S10 and Note 8/9/10: hold Volume Up + Bixby + Power instead</em>",
        "Keep holding until the Samsung logo appears, then release all buttons",
        "You are now in Recovery Mode — use <strong>Volume Up/Down</strong> to move, <strong>Power</strong> to select",
        "Navigate to <strong>Wipe data / Factory reset</strong> and press Power",
        "Navigate to <strong>Yes</strong> and press Power to confirm",
        "When done, navigate to <strong>Reboot system now</strong> and press Power"
      ],
    }
  },

  // ── INFINIX ────────────────────────────────────────────────────────
  "Infinix": {
    models: [
      "Hot 9","Hot 9 Play","Hot 10","Hot 10 Play","Hot 10i","Hot 10s",
      "Hot 11","Hot 11 Play","Hot 11s","Hot 11s NFC",
      "Hot 12","Hot 12 Play","Hot 12i","Hot 12 Pro",
      "Hot 20","Hot 20 Play","Hot 20i","Hot 20s",
      "Hot 30","Hot 30 Play","Hot 30i","Hot 30 5G",
      "Hot 40","Hot 40 Pro","Hot 40i",
      "Note 10","Note 10 Pro","Note 11","Note 11 Pro","Note 11s",
      "Note 12","Note 12 Pro","Note 12 VIP","Note 12 G96","Note 12 Turbo",
      "Note 30","Note 30 Pro","Note 30 VIP",
      "Note 40","Note 40 Pro","Note 40 Pro+",
      "Smart 5","Smart 6","Smart 6 HD","Smart 6 Plus","Smart 7","Smart 7 HD",
      "Smart 8","Smart 8 HD","Smart 8 Plus","Smart 8 Pro",
      "Zero 5G","Zero 20","Zero 30","Zero 30 5G","Zero 40","Zero 40 5G",
      "GT 10 Pro","GT 20 Pro",
    ],
    settings: {
      default: [
        "Open <strong>Settings</strong> on your Infinix",
        "Scroll down to the bottom and tap <strong>System</strong>",
        "Tap <strong>Reset options</strong>",
        "Tap <strong>Erase all data (factory reset)</strong>",
        "Tap <strong>Erase all data</strong> at the bottom",
        "Enter your PIN or password if asked",
        "Tap <strong>Erase all data</strong> again to confirm — phone restarts and wipes"
      ],
    },
    hardware: {
      default: [
        "Power off your Infinix completely",
        "Press and hold <strong>Power + Volume Up</strong> at the same time",
        "When the Infinix logo appears, release the Power button but <strong>keep holding Volume Up</strong>",
        "You are now in Recovery Mode — use <strong>Volume Up/Down</strong> to scroll, <strong>Power</strong> to select",
        "Navigate to <strong>Wipe data / Factory reset</strong> and press Power",
        "Navigate to <strong>Factory data reset</strong> and press Power",
        "Navigate to <strong>Yes</strong> and press Power to confirm",
        "When done, select <strong>Reboot system now</strong>"
      ],
      "Hot 30": [
        "Power off your Infinix Hot 30",
        "Press and hold <strong>Power + Volume Up</strong> simultaneously",
        "When the Infinix logo appears, release Power but <strong>keep holding Volume Up</strong> until the XOS image shows",
        "While holding Power, press Volume Up once to enter Recovery",
        "Use Volume Up/Down to navigate to <strong>Wipe data / Factory reset</strong>, press Power",
        "Select <strong>Factory data reset</strong>, press Power",
        "Select <strong>Yes</strong> to confirm, press Power",
        "When done, select <strong>Reboot system now</strong>"
      ],
      "Hot 30i": [
        "Power off your Infinix Hot 30i",
        "Press and hold <strong>Power + Volume Up</strong>",
        "When you see the Infinix logo, release Power but keep holding Volume Up",
        "When the 'No command' image appears, hold Power then press Volume Up once",
        "Use volume buttons to navigate to <strong>Wipe data/factory reset</strong>, press Power",
        "Select <strong>Yes — delete all user data</strong>, press Power",
        "Select <strong>Reboot system now</strong> when complete"
      ],
    }
  },

  // ── TECNO ──────────────────────────────────────────────────────────
  "Tecno": {
    models: [
      "Spark 6","Spark 6 Go","Spark 7","Spark 7 Go","Spark 7P","Spark 7T",
      "Spark 8","Spark 8C","Spark 8P","Spark 8 Pro","Spark 8T",
      "Spark 9","Spark 9 Pro","Spark 9T","Spark 9 Play",
      "Spark 10","Spark 10 Pro","Spark 10C","Spark 10P",
      "Spark 20","Spark 20 Pro","Spark 20C","Spark 20 Pro+",
      "Camon 17","Camon 17P","Camon 17 Pro",
      "Camon 18","Camon 18P","Camon 18 Premier","Camon 18T",
      "Camon 19","Camon 19 Pro","Camon 19 Neo",
      "Camon 20","Camon 20 Pro","Camon 20 Premier","Camon 20S",
      "Pop 5","Pop 5 Go","Pop 5 LTE","Pop 5P","Pop 5 Pro",
      "Pop 6","Pop 6 Go","Pop 6 Pro",
      "Pop 7","Pop 7 Pro","Pop 8",
      "Pova","Pova 2","Pova 3","Pova 4","Pova 4 Pro","Pova 5","Pova 5 Pro",
    ],
    settings: {
      default: [
        "Open <strong>Settings</strong>",
        "Scroll to the bottom and tap <strong>System</strong>",
        "Tap <strong>Reset options</strong>",
        "Tap <strong>Erase all data (factory reset)</strong>",
        "Tap <strong>Erase all data</strong>",
        "Enter your PIN or password if prompted",
        "Tap <strong>Erase all data</strong> to confirm"
      ],
    },
    hardware: {
      default: [
        "Turn off your Tecno phone",
        "Press and hold <strong>Power + Volume Up</strong>",
        "Release Power when logo appears, keep holding Volume Up",
        "In Recovery Mode, navigate with Volume buttons, select with Power",
        "Select <strong>Wipe data / Factory reset</strong>",
        "Select <strong>Yes</strong> to confirm",
        "Select <strong>Reboot system now</strong> when complete"
      ],
    }
  },

  // ── ITEL ───────────────────────────────────────────────────────────
  "Itel": {
    models: [
      "A23 Pro","A25","A25 Pro","A26","A27",
      "A33","A36","A37","A48",
      "P33","P33 Plus","P36","P36 Pro","P37","P37 Pro","P38","P38 Pro",
      "P55","P55 Plus","P55 Pro","P65",
      "S16","S16 Pro","S17","S17 Pro","S18","S19","S19 Pro",
      "Vision 1","Vision 1 Pro","Vision 1 Plus",
      "Vision 2","Vision 2 Plus","Vision 3","Vision 3 Plus","Vision 3 Pro",
      "A70","A70s",
    ],
    settings: {
      default: [
        "Open <strong>Settings</strong>",
        "Tap <strong>System</strong>",
        "Tap <strong>Reset options</strong>",
        "Tap <strong>Erase all data (factory reset)</strong>",
        "Tap <strong>Erase all data</strong> and confirm"
      ],
    },
    hardware: {
      default: [
        "Turn off your Itel phone",
        "Press and hold <strong>Power + Volume Up</strong>",
        "Release when the logo appears, keep holding Volume Up",
        "Select <strong>Wipe data / Factory reset</strong> using volume buttons",
        "Press Power to confirm, select Yes",
        "Select <strong>Reboot system now</strong>"
      ],
    }
  },

  // ── XIAOMI / REDMI / POCO ──────────────────────────────────────────
  "Xiaomi": {
    models: [
      "Redmi 9","Redmi 9A","Redmi 9C","Redmi 9i","Redmi 9T",
      "Redmi 10","Redmi 10A","Redmi 10C","Redmi 10 Prime",
      "Redmi 12","Redmi 12C","Redmi 12 5G",
      "Redmi 13C","Redmi 13 5G",
      "Redmi Note 9","Redmi Note 9 Pro","Redmi Note 9S","Redmi Note 9 Pro Max",
      "Redmi Note 10","Redmi Note 10 Pro","Redmi Note 10S","Redmi Note 10 5G",
      "Redmi Note 11","Redmi Note 11 Pro","Redmi Note 11S","Redmi Note 11 5G",
      "Redmi Note 12","Redmi Note 12 Pro","Redmi Note 12S","Redmi Note 12 5G",
      "Redmi Note 13","Redmi Note 13 Pro","Redmi Note 13 Pro+",
      "POCO M2","POCO M2 Pro","POCO M3","POCO M3 Pro",
      "POCO M4","POCO M4 Pro","POCO M4 5G","POCO M5","POCO M5s","POCO M6 Pro",
      "POCO X3","POCO X3 NFC","POCO X3 Pro","POCO X4 Pro","POCO X5 Pro","POCO X6 Pro",
      "POCO F3","POCO F4","POCO F5","POCO F6",
      "Mi 10","Mi 10T","Mi 11","Mi 11 Lite","Mi 11i",
      "Xiaomi 11T","Xiaomi 12","Xiaomi 13","Xiaomi 14",
    ],
    settings: {
      default: [
        "Open <strong>Settings</strong>",
        "Tap <strong>About phone</strong> (at the bottom on most MIUI/HyperOS versions)",
        "Tap <strong>Factory reset</strong>",
        "Tap <strong>Reset phone</strong>",
        "Enter your password or PIN if asked",
        "Tap <strong>Continue</strong>",
        "Tap <strong>OK</strong> to confirm — wipe begins"
      ],
    },
    hardware: {
      default: [
        "Turn off your Xiaomi/Redmi/POCO",
        "Press and hold <strong>Power + Volume Up</strong>",
        "When the MI logo appears, release both buttons",
        "In Recovery Mode, use Volume buttons to navigate, Power to select",
        "Select <strong>Wipe Data</strong>",
        "Select <strong>Wipe All Data</strong>",
        "Tap <strong>Confirm</strong> — wipe begins"
      ],
    }
  },

  // ── HUAWEI / HONOR ─────────────────────────────────────────────────
  "Huawei": {
    models: [
      "P Smart 2019","P Smart 2020","P Smart 2021",
      "P30","P30 Lite","P30 Pro","P40","P40 Lite","P40 Pro","P50","P50 Pro",
      "Mate 20","Mate 20 Lite","Mate 20 Pro","Mate 30","Mate 30 Pro",
      "Mate 40","Mate 50",
      "Nova 5T","Nova 6","Nova 7","Nova 7i","Nova 8","Nova 9","Nova 10","Nova 11",
      "Y6 2019","Y6p","Y7 2019","Y7a","Y7p","Y8p","Y9 2019","Y9a","Y9 Prime 2019",
      "Honor 9X","Honor 9A","Honor 10X","Honor 50","Honor 70","Honor 90",
      "Honor X6","Honor X7","Honor X8","Honor X9",
    ],
    settings: {
      default: [
        "Open <strong>Settings</strong>",
        "Tap <strong>System</strong> (or scroll down to find it)",
        "Tap <strong>Reset</strong>",
        "Tap <strong>Factory data reset</strong>",
        "Tap <strong>Reset phone</strong>",
        "Enter your PIN or password if asked",
        "Tap <strong>Erase everything</strong> to confirm"
      ],
    },
    hardware: {
      default: [
        "Turn off your Huawei",
        "Press and hold <strong>Power + Volume Up</strong>",
        "Keep holding until the Huawei logo appears",
        "Use Volume buttons to navigate to <strong>Wipe data / Factory reset</strong>",
        "Press Power to select",
        "Select <strong>Yes</strong> and press Power",
        "Select <strong>Reboot system now</strong>"
      ],
    }
  },

  // ── OPPO ───────────────────────────────────────────────────────────
  "OPPO": {
    models: [
      "A5 2020","A9 2020","A12","A15","A15s","A16","A16s","A16k","A16e",
      "A17","A17k","A18","A38","A58","A78","A98",
      "A53","A53s","A54","A54s","A55","A57","A57s",
      "A74","A74 5G","A76","A77","A77s",
      "A91","A92","A93","A94","A95","A96",
      "Reno 4","Reno 4 Pro","Reno 5","Reno 5 Pro","Reno 6","Reno 6 Pro",
      "Reno 7","Reno 7 Pro","Reno 8","Reno 8 Pro","Reno 8T",
      "Reno 10","Reno 10 Pro","Reno 11","Reno 11 Pro",
      "F19","F19 Pro","F19s","F21 Pro","F21s Pro","F23 5G",
    ],
    settings: {
      default: [
        "Open <strong>Settings</strong>",
        "Tap <strong>Additional settings</strong>",
        "Tap <strong>Back up and reset</strong>",
        "Tap <strong>Erase all data (factory reset)</strong>",
        "Tap <strong>Erase all data</strong>",
        "Enter your PIN if asked and confirm"
      ],
    },
    hardware: {
      default: [
        "Turn off your OPPO",
        "Press and hold <strong>Power + Volume Down</strong>",
        "When Recovery Mode appears, use Volume buttons to navigate",
        "Select <strong>Wipe data and cache</strong>",
        "Select <strong>Wipe data / Factory reset</strong>",
        "Select <strong>Yes</strong> and confirm",
        "Reboot the device"
      ],
    }
  },

  // ── VIVO ───────────────────────────────────────────────────────────
  "Vivo": {
    models: [
      "Y01","Y01A","Y02","Y02A","Y02s","Y02t",
      "Y11","Y11s","Y12","Y12s","Y12G","Y15","Y15s","Y15A",
      "Y16","Y17s","Y20","Y20G","Y20i","Y20s","Y21","Y21A","Y21s","Y21T","Y21e","Y21G",
      "Y22","Y22s","Y27","Y27s","Y30","Y30i","Y33e","Y33s","Y33T",
      "Y35","Y36","Y50","Y51","Y51A","Y53s","Y55","Y55s","Y72","Y75","Y76","Y76s",
      "V20","V20 Pro","V20 SE","V21","V21e","V21 5G",
      "V23","V23e","V23 5G","V25","V25e","V25 Pro",
      "V27","V27 Pro","V27e","V29","V29 Pro","V29e",
      "T1","T1 Pro","T1 5G","T1x","T2","T2x","T2 Pro",
      "X60","X60 Pro","X70","X70 Pro","X80","X90","X100",
    ],
    settings: {
      default: [
        "Open <strong>Settings</strong>",
        "Scroll down and tap <strong>General</strong>",
        "Tap <strong>Reset</strong>",
        "Tap <strong>Factory reset</strong>",
        "Tap <strong>Reset phone</strong>",
        "Enter your PIN or password if asked",
        "Tap <strong>OK</strong> to confirm"
      ],
    },
    hardware: {
      default: [
        "Turn off your Vivo",
        "Press and hold <strong>Power + Volume Up</strong>",
        "Keep holding until Recovery Mode appears",
        "Navigate with Volume buttons, select with Power",
        "Select <strong>Wipe data/factory reset</strong>",
        "Select <strong>Yes</strong> to confirm",
        "Select <strong>Reboot system now</strong>"
      ],
    }
  },

  // ── REALME ─────────────────────────────────────────────────────────
  "Realme": {
    models: [
      "C3","C11","C11 2021","C12","C15","C15 Qualcomm","C17","C20","C20A",
      "C21","C21Y","C21s","C25","C25s","C25Y","C30","C30s","C31","C33","C35","C51","C53","C55","C65",
      "5","5 Pro","5i","5s","6","6 Pro","6i","6s","7","7 Pro","7i",
      "8","8 Pro","8i","8s","9","9 Pro","9 Pro+","9i","9 SE",
      "10","10 Pro","10 Pro+","11","11 Pro","11 Pro+","11x",
      "12","12 Pro","12 Pro+","12x","Narzo 20","Narzo 30","Narzo 50","Narzo 60",
      "GT","GT 2","GT 2 Pro","GT Neo 2","GT Neo 3","GT 3","GT 5 Pro",
    ],
    settings: {
      default: [
        "Open <strong>Settings</strong>",
        "Tap <strong>Additional Settings</strong>",
        "Tap <strong>Back up and reset</strong>",
        "Tap <strong>Factory data reset</strong>",
        "Tap <strong>Reset phone</strong>",
        "Enter your PIN or password if asked",
        "Tap <strong>Erase Everything</strong> to confirm"
      ],
    },
    hardware: {
      default: [
        "Turn off your Realme",
        "Press and hold <strong>Power + Volume Down</strong>",
        "When Recovery Mode appears, use Volume to navigate, Power to select",
        "Select <strong>Wipe data and cache</strong>",
        "Select <strong>Wipe data / Factory reset</strong>",
        "Confirm with <strong>Yes</strong>",
        "Reboot the device"
      ],
    }
  },

  // ── NOKIA ──────────────────────────────────────────────────────────
  "Nokia": {
    models: [
      "1.3","1.4","2.2","2.3","2.4","3.1","3.2","3.4","3.1 Plus",
      "4.2","5.1","5.1 Plus","5.3","5.4","6.1","6.1 Plus","6.2",
      "7.1","7.2","7 Plus","8.1","8.3","8 Sirocco",
      "C01 Plus","C02","C10","C20","C20 Plus","C21","C21 Plus","C30",
      "G10","G11","G11 Plus","G20","G21","G22","G50","G60",
      "T10","T20","T21",
      "X10","X20","X30",
    ],
    settings: {
      default: [
        "Open <strong>Settings</strong>",
        "Tap <strong>System</strong>",
        "Tap <strong>Advanced</strong>",
        "Tap <strong>Reset options</strong>",
        "Tap <strong>Erase all data (factory reset)</strong>",
        "Tap <strong>Reset phone</strong>",
        "Enter your PIN if asked, then tap <strong>Erase everything</strong>"
      ],
    },
    hardware: {
      default: [
        "Turn off your Nokia",
        "Press and hold <strong>Power + Volume Down</strong>",
        "When the Nokia logo appears, release and re-press Volume Down",
        "In Recovery Mode, use Volume to navigate, Power to select",
        "Select <strong>Wipe data / Factory reset</strong>",
        "Select <strong>Yes</strong> and confirm",
        "Reboot"
      ],
    }
  },

  // ── MOTOROLA ───────────────────────────────────────────────────────
  "Motorola": {
    models: [
      "Moto E6 Play","Moto E6 Plus","Moto E6s","Moto E7","Moto E7 Plus","Moto E7 Power",
      "Moto E8","Moto E13","Moto E14","Moto E20","Moto E22","Moto E30","Moto E32",
      "Moto E40","Moto E50",
      "Moto G8","Moto G8 Plus","Moto G8 Power","Moto G8 Play",
      "Moto G9","Moto G9 Play","Moto G9 Plus","Moto G9 Power",
      "Moto G10","Moto G20","Moto G30","Moto G31","Moto G41","Moto G50","Moto G51","Moto G52",
      "Moto G60","Moto G60s","Moto G62","Moto G71","Moto G72","Moto G73","Moto G82","Moto G84",
      "Moto G100","Moto G200","Moto G Stylus","Moto G Power",
      "Moto Edge 20","Moto Edge 30","Moto Edge 40","Moto Edge 50",
    ],
    settings: {
      default: [
        "Open <strong>Settings</strong>",
        "Tap <strong>System</strong>",
        "Tap <strong>Reset options</strong>",
        "Tap <strong>Erase all data (factory reset)</strong>",
        "Tap <strong>Reset phone</strong>",
        "Enter your PIN or password if asked",
        "Tap <strong>Erase everything</strong> to confirm"
      ],
    },
    hardware: {
      default: [
        "Turn off your Motorola",
        "Press and hold <strong>Power + Volume Down</strong> for ~10 seconds",
        "When Recovery Mode appears, use Volume to navigate, Power to select",
        "Select <strong>Wipe data / Factory reset</strong>",
        "Select <strong>Yes</strong> and confirm",
        "Select <strong>Reboot system now</strong>"
      ],
    }
  },

  // ── iPHONE ─────────────────────────────────────────────────────────
  "iPhone": {
    models: [
      "iPhone 7","iPhone 7 Plus",
      "iPhone 8","iPhone 8 Plus",
      "iPhone X","iPhone XR","iPhone XS","iPhone XS Max",
      "iPhone 11","iPhone 11 Pro","iPhone 11 Pro Max",
      "iPhone SE (2nd gen)","iPhone SE (3rd gen)",
      "iPhone 12","iPhone 12 Mini","iPhone 12 Pro","iPhone 12 Pro Max",
      "iPhone 13","iPhone 13 Mini","iPhone 13 Pro","iPhone 13 Pro Max",
      "iPhone 14","iPhone 14 Plus","iPhone 14 Pro","iPhone 14 Pro Max",
      "iPhone 15","iPhone 15 Plus","iPhone 15 Pro","iPhone 15 Pro Max",
      "iPhone 16","iPhone 16 Plus","iPhone 16 Pro","iPhone 16 Pro Max",
    ],
    settings: {
      default: [
        "<strong>FIRST — Sign out of iCloud</strong>: Settings → [Your Name] → scroll down → Sign Out → enter Apple ID password. This removes Activation Lock so the next owner can use the phone.",
        "Go to <strong>Settings</strong>",
        "Tap <strong>General</strong>",
        "Scroll to the bottom and tap <strong>Transfer or Reset iPhone</strong>",
        "Tap <strong>Erase All Content and Settings</strong>",
        "Enter your passcode if asked",
        "Tap <strong>Erase iPhone</strong> to confirm — takes 5–10 minutes"
      ],
    },
    hardware: {
      default: [
        "<strong>Connect to a computer</strong> with iTunes (Windows) or Finder (Mac)",
        "Put the iPhone into DFU mode:",
        "<em>iPhone 8 and newer:</em> Press and release Volume Up, press and release Volume Down, then press and hold Side button until the screen goes black — keep holding Side button, then hold Volume Down too until iTunes/Finder detects recovery mode",
        "<em>iPhone 7/7 Plus:</em> Press and hold Volume Down + Side button until recovery mode is detected",
        "In iTunes/Finder, click <strong>Restore iPhone</strong>",
        "Confirm and wait — downloads the latest iOS and restores the phone",
        "This is the most thorough method — removes everything including Activation Lock in some cases"
      ],
    }
  },

  // ── GOOGLE PIXEL ───────────────────────────────────────────────────
  "Google Pixel": {
    models: [
      "Pixel 3","Pixel 3 XL","Pixel 3a","Pixel 3a XL",
      "Pixel 4","Pixel 4 XL","Pixel 4a","Pixel 4a 5G",
      "Pixel 5","Pixel 5a",
      "Pixel 6","Pixel 6 Pro","Pixel 6a",
      "Pixel 7","Pixel 7 Pro","Pixel 7a",
      "Pixel 8","Pixel 8 Pro","Pixel 8a",
      "Pixel 9","Pixel 9 Pro","Pixel 9 Pro XL","Pixel 9 Pro Fold",
    ],
    settings: {
      default: [
        "Open <strong>Settings</strong>",
        "Tap <strong>System</strong>",
        "Tap <strong>Reset options</strong>",
        "Tap <strong>Erase all data (factory reset)</strong>",
        "Tap <strong>Reset phone</strong>",
        "Enter your PIN or password",
        "Tap <strong>Erase everything</strong>"
      ],
    },
    hardware: {
      default: [
        "Turn off your Pixel",
        "Press and hold <strong>Power + Volume Down</strong>",
        "Use Volume buttons to navigate to <strong>Recovery mode</strong>, press Power",
        "When you see the Android logo with an exclamation, press <strong>Power + Volume Up</strong> briefly",
        "Navigate to <strong>Wipe data / Factory reset</strong>",
        "Confirm with <strong>Yes</strong>",
        "Select <strong>Reboot system now</strong>"
      ],
    }
  },

  // ── OnePlus ────────────────────────────────────────────────────────
  "OnePlus": {
    models: [
      "OnePlus 6T","OnePlus 7","OnePlus 7 Pro","OnePlus 7T","OnePlus 7T Pro",
      "OnePlus 8","OnePlus 8 Pro","OnePlus 8T",
      "OnePlus 9","OnePlus 9 Pro","OnePlus 9R","OnePlus 9RT",
      "OnePlus 10 Pro","OnePlus 10T","OnePlus 10R",
      "OnePlus 11","OnePlus 11R","OnePlus 12","OnePlus 12R",
      "Nord","Nord CE","Nord 2","Nord 2T","Nord CE 2","Nord CE 2 Lite",
      "Nord CE 3","Nord CE 3 Lite","Nord 3","Nord 4",
      "Nord N10","Nord N20","Nord N30",
    ],
    settings: {
      default: [
        "Open <strong>Settings</strong>",
        "Tap <strong>Additional settings</strong>",
        "Tap <strong>Back up and reset</strong>",
        "Tap <strong>Erase all data (factory reset)</strong>",
        "Tap <strong>Erase all data</strong>",
        "Enter your PIN or password if asked",
        "Confirm to start the wipe"
      ],
    },
    hardware: {
      default: [
        "Turn off your OnePlus",
        "Press and hold <strong>Power + Volume Down</strong>",
        "When you see the OnePlus logo, select <strong>Recovery</strong> using volume buttons",
        "Press Power to enter Recovery Mode",
        "Select <strong>Wipe data / Factory reset</strong>",
        "Confirm with <strong>Yes</strong>",
        "Reboot"
      ],
    }
  },

};

// ── Autocomplete logic ─────────────────────────────────────────────
const brands   = Object.keys(DB);
let currentBrand = null;
let selectedModel = null;

const brandInput = document.getElementById('brandInput');
const modelInput = document.getElementById('modelInput');
const brandList  = document.getElementById('brandList');
const modelList  = document.getElementById('modelList');
const findBtn    = document.getElementById('findBtn');

function showList(input, list, items, onSelect) {
  list.innerHTML = '';
  if (!items.length) { list.style.display='none'; return; }
  items.forEach(item => {
    const d = document.createElement('div');
    d.className = 'ac-item';
    const val  = input.value;
    const idx  = item.toLowerCase().indexOf(val.toLowerCase());
    if (idx >= 0) {
      d.innerHTML = item.slice(0,idx)
        + '<strong>' + item.slice(idx, idx+val.length) + '</strong>'
        + item.slice(idx+val.length);
    } else {
      d.textContent = item;
    }
    d.addEventListener('mousedown', e => {
      e.preventDefault();
      onSelect(item);
    });
    list.appendChild(d);
  });
  list.style.display = 'block';
}

function hideAll() {
  brandList.style.display = 'none';
  modelList.style.display = 'none';
}

// Brand input
brandInput.addEventListener('input', () => {
  const q = brandInput.value.trim().toLowerCase();
  currentBrand = null;
  modelInput.disabled = true;
  modelInput.value = '';
  selectedModel = null;
  findBtn.disabled = true;
  if (!q) { hideAll(); return; }
  const matches = brands.filter(b => b.toLowerCase().includes(q));
  showList(brandInput, brandList, matches, brand => {
    brandInput.value = brand;
    currentBrand = brand;
    brandList.style.display = 'none';
    modelInput.disabled = false;
    modelInput.focus();
  });
});

brandInput.addEventListener('keydown', e => {
  const items = brandList.querySelectorAll('.ac-item');
  if (e.key === 'Enter' && items.length === 1) {
    items[0].dispatchEvent(new MouseEvent('mousedown'));
  }
});

brandInput.addEventListener('blur', () => {
  setTimeout(() => brandList.style.display='none', 150);
});

// Model input
modelInput.addEventListener('input', () => {
  selectedModel = null;
  findBtn.disabled = true;
  const q = modelInput.value.trim().toLowerCase();
  if (!currentBrand || !q) { modelList.style.display='none'; return; }
  const models = DB[currentBrand].models;
  const matches = models.filter(m => m.toLowerCase().includes(q));
  showList(modelInput, modelList, matches, model => {
    modelInput.value = model;
    selectedModel = model;
    modelList.style.display = 'none';
    findBtn.disabled = false;
  });
});

modelInput.addEventListener('keydown', e => {
  const items = modelList.querySelectorAll('.ac-item');
  if (e.key === 'Enter' && items.length === 1) {
    items[0].dispatchEvent(new MouseEvent('mousedown'));
  }
});

modelInput.addEventListener('blur', () => {
  setTimeout(() => modelList.style.display='none', 150);
});

// ── Find instructions ──────────────────────────────────────────────
findBtn.addEventListener('click', showInstructions);

function showInstructions() {
  if (!currentBrand || !selectedModel) return;

  const brand = DB[currentBrand];
  const settingsSteps = brand.settings[selectedModel] || brand.settings.default;
  const hardwareSteps = brand.hardware[selectedModel] || brand.hardware.default;

  document.getElementById('deviceBadge').textContent =
    currentBrand + ' ' + selectedModel;

  renderSteps('settingsSteps', settingsSteps);
  renderSteps('hardwareSteps', hardwareSteps);

  document.getElementById('selectorCard').style.display = 'none';
  document.getElementById('instructionsWrap').style.display = 'block';

  // Log to DB
  fetch('log_erase_start.php', {
    method: 'POST',
    headers: {'Content-Type':'application/json'},
    body: JSON.stringify({
      device_type:  currentBrand === 'iPhone' ? 'iphone' : 'android',
      device_model: currentBrand + ' ' + selectedModel,
      tool_type:    'web'
    })
  });

  window.scrollTo({top:0, behavior:'smooth'});
}

function renderSteps(containerId, steps) {
  const container = document.getElementById(containerId);
  container.innerHTML = steps.map((step, i) => `
    <div class="step-item" id="step-${containerId}-${i}">
      <div class="step-num">${i+1}</div>
      <div class="step-body">
        <div class="step-text">${step}</div>
        <button class="step-done-btn" onclick="markDone('${containerId}',${i},${steps.length})">
          ✓ Done
        </button>
      </div>
    </div>
  `).join('');
}

function markDone(containerId, idx, total) {
  const el = document.getElementById(`step-${containerId}-${idx}`);
  el.classList.add('step-completed');
  el.querySelector('.step-done-btn').style.display = 'none';

  // Check if all steps done
  const all = document.querySelectorAll(`#${containerId} .step-item`);
  const done = document.querySelectorAll(`#${containerId} .step-completed`);
  if (all.length === done.length) {
    document.getElementById('instructionsWrap').insertAdjacentHTML('beforeend',`
      <div class="completed-banner" id="completedBanner">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
             stroke-linecap="round" stroke-linejoin="round">
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
          <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        All steps completed! Your phone is now being wiped.
      </div>
    `);
  }
}

function showMethod(method) {
  document.getElementById('panelSettings').style.display =
    method === 'settings' ? 'block' : 'none';
  document.getElementById('panelHardware').style.display =
    method === 'hardware' ? 'block' : 'none';
  document.getElementById('tabSettings').classList.toggle('active', method==='settings');
  document.getElementById('tabHardware').classList.toggle('active', method==='hardware');
}

function resetSearch() {
  document.getElementById('selectorCard').style.display = 'block';
  document.getElementById('instructionsWrap').style.display = 'none';
  const cb = document.getElementById('completedBanner');
  if (cb) cb.remove();
  brandInput.value = '';
  modelInput.value = '';
  modelInput.disabled = true;
  findBtn.disabled = true;
  currentBrand = null;
  selectedModel = null;
  // Reset step highlights
  document.querySelectorAll('.step-item').forEach(el => {
    el.classList.remove('step-completed');
    const btn = el.querySelector('.step-done-btn');
    if (btn) btn.style.display = '';
  });
}
</script>

<style>
.erase-page { max-width:820px; margin:0 auto; padding:48px 24px; }

.erase-header { text-align:center; margin-bottom:36px; }
.erase-header h1 {
  font-family:var(--font-display); font-size:clamp(1.8rem,3vw,2.4rem);
  font-weight:800; color:var(--text-primary); margin-bottom:10px;
}
.erase-header p { font-size:.95rem; color:var(--text-secondary); max-width:560px; margin:0 auto; }

/* ── Selector card ──────────────────────────────────────────── */
.phone-selector-card {
  background:var(--bg-glass); backdrop-filter:blur(14px);
  border:1px solid var(--border); border-radius:20px;
  padding:32px; margin-bottom:28px;
}
.selector-grid {
  display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:22px;
}
.selector-field label {
  display:block; font-size:.8rem; font-weight:700; text-transform:uppercase;
  letter-spacing:.4px; color:var(--text-muted); margin-bottom:8px;
}
.autocomplete-wrap { position:relative; }
.autocomplete-wrap input {
  width:100%; padding:13px 16px; font-size:.95rem;
  background:var(--bg-elevated); color:var(--text-primary);
  border:1px solid var(--border); border-radius:10px;
  outline:none; transition:.2s; box-sizing:border-box;
}
.autocomplete-wrap input:focus {
  border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-glow);
}
.autocomplete-wrap input:disabled { opacity:.4; cursor:not-allowed; }

.autocomplete-list {
  position:absolute; top:calc(100% + 4px); left:0; right:0; z-index:100;
  background:var(--bg-surface); border:1px solid var(--border);
  border-radius:10px; box-shadow:var(--shadow-lg);
  max-height:220px; overflow-y:auto; display:none;
}
.ac-item {
  padding:11px 16px; font-size:.9rem; color:var(--text-secondary);
  cursor:pointer; transition:background .15s;
}
.ac-item:hover { background:var(--bg-elevated); color:var(--text-primary); }
.ac-item strong { color:var(--accent); font-weight:700; }

.btn-find {
  display:flex; align-items:center; justify-content:center; gap:8px;
  width:100%; padding:14px; background:var(--accent); color:#fff;
  border:none; border-radius:12px; font-family:var(--font-display);
  font-size:1rem; font-weight:700; cursor:pointer;
  box-shadow:0 6px 20px var(--accent-glow); transition:.2s;
}
.btn-find:hover { background:var(--accent-hover); transform:translateY(-2px); }
.btn-find:disabled { background:var(--border); box-shadow:none; cursor:not-allowed; transform:none; color:var(--text-muted); }
.btn-find svg { width:18px; height:18px; }

/* ── Instructions ────────────────────────────────────────────── */
.device-badge {
  display:inline-flex; padding:6px 16px; margin-bottom:18px;
  background:rgba(14,165,233,.1); border:1px solid var(--border-accent);
  border-radius:20px; font-family:var(--font-display);
  font-size:.9rem; font-weight:700; color:var(--accent);
}

.warn-box {
  display:flex; gap:12px; align-items:flex-start;
  background:rgba(245,158,11,.07); border:1px solid rgba(245,158,11,.25);
  border-left:4px solid var(--warning); border-radius:12px;
  padding:14px 16px; font-size:.875rem; color:var(--text-secondary);
  margin-bottom:22px; line-height:1.6;
}
.warn-box svg { width:20px; height:20px; flex-shrink:0; color:var(--warning); margin-top:2px; }
.warn-box strong { color:var(--text-primary); }

/* ── Method tabs ──────────────────────────────────────────────── */
.method-tabs { display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap; }
.method-tab {
  display:flex; align-items:center; gap:8px;
  padding:10px 18px; border-radius:10px; font-size:.875rem; font-weight:600;
  cursor:pointer; transition:.2s;
  background:var(--bg-elevated); border:1px solid var(--border);
  color:var(--text-secondary);
}
.method-tab:hover { border-color:var(--border-accent); color:var(--text-primary); }
.method-tab.active {
  background:rgba(14,165,233,.1); border-color:var(--border-accent);
  color:var(--accent);
}
.tab-badge {
  font-size:.7rem; font-weight:700; padding:2px 8px;
  background:var(--bg-surface); border:1px solid var(--border);
  border-radius:20px; color:var(--text-muted);
}

/* ── Steps ────────────────────────────────────────────────────── */
.steps-list { display:flex; flex-direction:column; gap:8px; }
.step-item {
  display:flex; gap:14px; align-items:flex-start;
  background:var(--bg-glass); border:1px solid var(--border);
  border-radius:12px; padding:16px; transition:.3s;
}
.step-item.step-completed {
  background:rgba(16,185,129,.06); border-color:rgba(16,185,129,.25);
  opacity:.7;
}
.step-num {
  width:28px; height:28px; flex-shrink:0;
  background:rgba(14,165,233,.1); border:1.5px solid var(--border-accent);
  border-radius:50%; display:flex; align-items:center; justify-content:center;
  font-family:var(--font-display); font-size:.8rem; font-weight:700;
  color:var(--accent);
}
.step-completed .step-num {
  background:rgba(16,185,129,.15); border-color:rgba(16,185,129,.4);
  color:var(--success);
}
.step-body { flex:1; }
.step-text { font-size:.9rem; color:var(--text-secondary); line-height:1.6; margin-bottom:10px; }
.step-text strong { color:var(--text-primary); }
.step-text em { color:var(--text-muted); font-style:italic; font-size:.85rem; }
.step-done-btn {
  padding:6px 14px; font-size:.8rem; font-weight:700;
  background:rgba(16,185,129,.1); border:1px solid rgba(16,185,129,.25);
  border-radius:8px; color:var(--success); cursor:pointer; transition:.2s;
}
.step-done-btn:hover { background:var(--success); color:#fff; }

/* ── Extras ───────────────────────────────────────────────────── */
.after-note {
  background:var(--bg-elevated); border:1px solid var(--border);
  border-radius:12px; padding:14px 18px; margin-top:22px;
  font-size:.84rem; color:var(--text-secondary); line-height:1.6;
}
.after-note strong { color:var(--text-primary); }

.btn-reset-search {
  display:inline-flex; margin-top:18px;
  background:none; border:none; font-size:.875rem;
  color:var(--text-muted); cursor:pointer; padding:0;
  transition:.2s;
}
.btn-reset-search:hover { color:var(--text-secondary); }

.completed-banner {
  display:flex; align-items:center; gap:12px;
  background:rgba(16,185,129,.1); border:1px solid rgba(16,185,129,.3);
  border-radius:14px; padding:18px 22px; margin-top:22px;
  font-family:var(--font-display); font-size:1rem; font-weight:700;
  color:var(--success);
}
.completed-banner svg { width:24px; height:24px; flex-shrink:0; }

@media(max-width:600px){
  .selector-grid { grid-template-columns:1fr; }
  .method-tabs { flex-direction:column; }
}
</style>

<?php include 'includes/footer.php'; ?>
