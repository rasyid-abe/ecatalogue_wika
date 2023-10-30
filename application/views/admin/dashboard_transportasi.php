<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
<section class="content-header">
  <h1>
    Dashboard Transportasi
    <small style="margin-top: -15px;">
        <select class="form-control" id="filter_tahun" onchange="App.getDataDashboard()">
            <option value="" disabled>Pilih Tahun</option>
            <?php
            $tahun = date('Y');
            foreach (range($tahun - 2, $tahun + 1) as $v) {
                $sel = "";
                if ($tahun == $v) {
                    $sel = "selected";
                }
                ?>
                <option value="<?= $v ?>" <?= $sel ?>><?= $v ?></option>
                <?php
            }
            ?>
        </select>
    </small>
    <small style="margin-top: -15px;">
        <select class="form-control" id="filter_bulan" onchange="App.getDataDashboard()">
            <option value="111">Pilih Bulan</option>
            <?php
            $now = date('m');
            foreach ($bulan as $id => $v) {
                ?>
                <option value="<?= $id ?>"><?= $v ?></option>
                <?php
            }
            ?>
        </select>
    </small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard Transportasi</li>
  </ol>
</section>

<style>
  .mycard {
    width: 100%;
    background-color: white;
    padding: 5px;
    color: black;
    font-weight: bold;
    border-radius: 3px;
  }

  .mb-3 {
    margin-bottom: 20px;
  }

  .card-text {
    margin-bottom: -2px;
    font-size: 9pt;
  }

  .line_space {
    margin: 2px auto;
    border: 1px solid gray;
  }

  .half_card {
    width: 50%;
    display: inline-block;
  }

  progress {
    width: 90%;
    height: 30px;
  }

  progress {
    color: lightblue;
  }

  progress::-webkit-progress-value {
    background: lightblue;
  }

  progress::-moz-progress-bar {
    background: lightcolor;
  }

  progress::-webkit-progress-value {
    background: red;
  }

  progress::-webkit-progress-bar {
    background: blue;
  }

  #mapid {
    height: 400px;
  }

  @import url("https://fonts.googleapis.com/css?family=Titillium+Web:200,200i,300,300i,400,400i,600,600i,700,700i,900");

  .rect-auto,
  .c100.p51 .slice,
  .c100.p52 .slice,
  .c100.p53 .slice,
  .c100.p54 .slice,
  .c100.p55 .slice,
  .c100.p56 .slice,
  .c100.p57 .slice,
  .c100.p58 .slice,
  .c100.p59 .slice,
  .c100.p60 .slice,
  .c100.p61 .slice,
  .c100.p62 .slice,
  .c100.p63 .slice,
  .c100.p64 .slice,
  .c100.p65 .slice,
  .c100.p66 .slice,
  .c100.p67 .slice,
  .c100.p68 .slice,
  .c100.p69 .slice,
  .c100.p70 .slice,
  .c100.p71 .slice,
  .c100.p72 .slice,
  .c100.p73 .slice,
  .c100.p74 .slice,
  .c100.p75 .slice,
  .c100.p76 .slice,
  .c100.p77 .slice,
  .c100.p78 .slice,
  .c100.p79 .slice,
  .c100.p80 .slice,
  .c100.p81 .slice,
  .c100.p82 .slice,
  .c100.p83 .slice,
  .c100.p84 .slice,
  .c100.p85 .slice,
  .c100.p86 .slice,
  .c100.p87 .slice,
  .c100.p88 .slice,
  .c100.p89 .slice,
  .c100.p90 .slice,
  .c100.p91 .slice,
  .c100.p92 .slice,
  .c100.p93 .slice,
  .c100.p94 .slice,
  .c100.p95 .slice,
  .c100.p96 .slice,
  .c100.p97 .slice,
  .c100.p98 .slice,
  .c100.p99 .slice,
  .c100.p100 .slice {
    clip: rect(auto, auto, auto, auto);
  }

  .pie,
  .c100 .bar,
  .c100.p51 .fill,
  .c100.p52 .fill,
  .c100.p53 .fill,
  .c100.p54 .fill,
  .c100.p55 .fill,
  .c100.p56 .fill,
  .c100.p57 .fill,
  .c100.p58 .fill,
  .c100.p59 .fill,
  .c100.p60 .fill,
  .c100.p61 .fill,
  .c100.p62 .fill,
  .c100.p63 .fill,
  .c100.p64 .fill,
  .c100.p65 .fill,
  .c100.p66 .fill,
  .c100.p67 .fill,
  .c100.p68 .fill,
  .c100.p69 .fill,
  .c100.p70 .fill,
  .c100.p71 .fill,
  .c100.p72 .fill,
  .c100.p73 .fill,
  .c100.p74 .fill,
  .c100.p75 .fill,
  .c100.p76 .fill,
  .c100.p77 .fill,
  .c100.p78 .fill,
  .c100.p79 .fill,
  .c100.p80 .fill,
  .c100.p81 .fill,
  .c100.p82 .fill,
  .c100.p83 .fill,
  .c100.p84 .fill,
  .c100.p85 .fill,
  .c100.p86 .fill,
  .c100.p87 .fill,
  .c100.p88 .fill,
  .c100.p89 .fill,
  .c100.p90 .fill,
  .c100.p91 .fill,
  .c100.p92 .fill,
  .c100.p93 .fill,
  .c100.p94 .fill,
  .c100.p95 .fill,
  .c100.p96 .fill,
  .c100.p97 .fill,
  .c100.p98 .fill,
  .c100.p99 .fill,
  .c100.p100 .fill {
    position: absolute;
    border: 0.09em solid #000000;
    width: 0.82em;
    height: 0.82em;
    clip: rect(0em, 0.5em, 1em, 0em);
    border-radius: 50%;
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  .pie-fill,
  .c100.p51 .bar:after,
  .c100.p51 .fill,
  .c100.p52 .bar:after,
  .c100.p52 .fill,
  .c100.p53 .bar:after,
  .c100.p53 .fill,
  .c100.p54 .bar:after,
  .c100.p54 .fill,
  .c100.p55 .bar:after,
  .c100.p55 .fill,
  .c100.p56 .bar:after,
  .c100.p56 .fill,
  .c100.p57 .bar:after,
  .c100.p57 .fill,
  .c100.p58 .bar:after,
  .c100.p58 .fill,
  .c100.p59 .bar:after,
  .c100.p59 .fill,
  .c100.p60 .bar:after,
  .c100.p60 .fill,
  .c100.p61 .bar:after,
  .c100.p61 .fill,
  .c100.p62 .bar:after,
  .c100.p62 .fill,
  .c100.p63 .bar:after,
  .c100.p63 .fill,
  .c100.p64 .bar:after,
  .c100.p64 .fill,
  .c100.p65 .bar:after,
  .c100.p65 .fill,
  .c100.p66 .bar:after,
  .c100.p66 .fill,
  .c100.p67 .bar:after,
  .c100.p67 .fill,
  .c100.p68 .bar:after,
  .c100.p68 .fill,
  .c100.p69 .bar:after,
  .c100.p69 .fill,
  .c100.p70 .bar:after,
  .c100.p70 .fill,
  .c100.p71 .bar:after,
  .c100.p71 .fill,
  .c100.p72 .bar:after,
  .c100.p72 .fill,
  .c100.p73 .bar:after,
  .c100.p73 .fill,
  .c100.p74 .bar:after,
  .c100.p74 .fill,
  .c100.p75 .bar:after,
  .c100.p75 .fill,
  .c100.p76 .bar:after,
  .c100.p76 .fill,
  .c100.p77 .bar:after,
  .c100.p77 .fill,
  .c100.p78 .bar:after,
  .c100.p78 .fill,
  .c100.p79 .bar:after,
  .c100.p79 .fill,
  .c100.p80 .bar:after,
  .c100.p80 .fill,
  .c100.p81 .bar:after,
  .c100.p81 .fill,
  .c100.p82 .bar:after,
  .c100.p82 .fill,
  .c100.p83 .bar:after,
  .c100.p83 .fill,
  .c100.p84 .bar:after,
  .c100.p84 .fill,
  .c100.p85 .bar:after,
  .c100.p85 .fill,
  .c100.p86 .bar:after,
  .c100.p86 .fill,
  .c100.p87 .bar:after,
  .c100.p87 .fill,
  .c100.p88 .bar:after,
  .c100.p88 .fill,
  .c100.p89 .bar:after,
  .c100.p89 .fill,
  .c100.p90 .bar:after,
  .c100.p90 .fill,
  .c100.p91 .bar:after,
  .c100.p91 .fill,
  .c100.p92 .bar:after,
  .c100.p92 .fill,
  .c100.p93 .bar:after,
  .c100.p93 .fill,
  .c100.p94 .bar:after,
  .c100.p94 .fill,
  .c100.p95 .bar:after,
  .c100.p95 .fill,
  .c100.p96 .bar:after,
  .c100.p96 .fill,
  .c100.p97 .bar:after,
  .c100.p97 .fill,
  .c100.p98 .bar:after,
  .c100.p98 .fill,
  .c100.p99 .bar:after,
  .c100.p99 .fill,
  .c100.p100 .bar:after,
  .c100.p100 .fill {
    -moz-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
  }

  /* .wrapper {
    width: 1200px;
    margin: 0 auto;
  } */

  .c100 {
    position: relative;
    font-size: 160px;
    width: 1em;
    height: 1em;
    border-radius: 50%;
    float: left;
    margin: 0.4em;
    background-color: #dfe8ed;
  }

  .c100 *,
  .c100 *:before,
  .c100 *:after {
    -moz-box-sizing: content-box;
    -webkit-box-sizing: content-box;
    box-sizing: content-box;
  }

  .c100>span {
    position: absolute;
    width: 100%;
    z-index: 1;
    left: 30%;
    top: 40%;
    width: 10px;
    line-height: 10px;
    font-size: 12pt;
    color: #3c4761;
    display: block;
    text-align: center;
    white-space: nowrap;
    -moz-transition-property: all;
    -o-transition-property: all;
    -webkit-transition-property: all;
    transition-property: all;
    -moz-transition-duration: 0.2s;
    -o-transition-duration: 0.2s;
    -webkit-transition-duration: 0.2s;
    transition-duration: 0.2s;
    -moz-transition-timing-function: ease-out;
    -o-transition-timing-function: ease-out;
    -webkit-transition-timing-function: ease-out;
    transition-timing-function: ease-out;
  }

  .c100:after {
    position: absolute;
    top: 0.09em;
    left: 0.09em;
    display: block;
    content: " ";
    border-radius: 50%;
    background-color: #ffffff;
    width: 0.82em;
    height: 0.82em;
    -moz-transition-property: all;
    -o-transition-property: all;
    -webkit-transition-property: all;
    transition-property: all;
    -moz-transition-duration: 0.2s;
    -o-transition-duration: 0.2s;
    -webkit-transition-duration: 0.2s;
    transition-duration: 0.2s;
    -moz-transition-timing-function: ease-in;
    -o-transition-timing-function: ease-in;
    -webkit-transition-timing-function: ease-in;
    transition-timing-function: ease-in;
  }

  .c100 .slice {
    position: absolute;
    width: 1em;
    height: 1em;
    clip: rect(0em, 1em, 1em, 0.5em);
  }

  .c100.p1 .bar {
    -moz-transform: rotate(3.6deg);
    -ms-transform: rotate(3.6deg);
    -webkit-transform: rotate(3.6deg);
    transform: rotate(3.6deg);
  }

  .c100.p2 .bar {
    -moz-transform: rotate(7.2deg);
    -ms-transform: rotate(7.2deg);
    -webkit-transform: rotate(7.2deg);
    transform: rotate(7.2deg);
  }

  .c100.p3 .bar {
    -moz-transform: rotate(10.8deg);
    -ms-transform: rotate(10.8deg);
    -webkit-transform: rotate(10.8deg);
    transform: rotate(10.8deg);
  }

  .c100.p4 .bar {
    -moz-transform: rotate(14.4deg);
    -ms-transform: rotate(14.4deg);
    -webkit-transform: rotate(14.4deg);
    transform: rotate(14.4deg);
  }

  .c100.p5 .bar {
    -moz-transform: rotate(18deg);
    -ms-transform: rotate(18deg);
    -webkit-transform: rotate(18deg);
    transform: rotate(18deg);
  }

  .c100.p6 .bar {
    -moz-transform: rotate(21.6deg);
    -ms-transform: rotate(21.6deg);
    -webkit-transform: rotate(21.6deg);
    transform: rotate(21.6deg);
  }

  .c100.p7 .bar {
    -moz-transform: rotate(25.2deg);
    -ms-transform: rotate(25.2deg);
    -webkit-transform: rotate(25.2deg);
    transform: rotate(25.2deg);
  }

  .c100.p8 .bar {
    -moz-transform: rotate(28.8deg);
    -ms-transform: rotate(28.8deg);
    -webkit-transform: rotate(28.8deg);
    transform: rotate(28.8deg);
  }

  .c100.p9 .bar {
    -moz-transform: rotate(32.4deg);
    -ms-transform: rotate(32.4deg);
    -webkit-transform: rotate(32.4deg);
    transform: rotate(32.4deg);
  }

  .c100.p10 .bar {
    -moz-transform: rotate(36deg);
    -ms-transform: rotate(36deg);
    -webkit-transform: rotate(36deg);
    transform: rotate(36deg);
  }

  .c100.p11 .bar {
    -moz-transform: rotate(39.6deg);
    -ms-transform: rotate(39.6deg);
    -webkit-transform: rotate(39.6deg);
    transform: rotate(39.6deg);
  }

  .c100.p12 .bar {
    -moz-transform: rotate(43.2deg);
    -ms-transform: rotate(43.2deg);
    -webkit-transform: rotate(43.2deg);
    transform: rotate(43.2deg);
  }

  .c100.p13 .bar {
    -moz-transform: rotate(46.8deg);
    -ms-transform: rotate(46.8deg);
    -webkit-transform: rotate(46.8deg);
    transform: rotate(46.8deg);
  }

  .c100.p14 .bar {
    -moz-transform: rotate(50.4deg);
    -ms-transform: rotate(50.4deg);
    -webkit-transform: rotate(50.4deg);
    transform: rotate(50.4deg);
  }

  .c100.p15 .bar {
    -moz-transform: rotate(54deg);
    -ms-transform: rotate(54deg);
    -webkit-transform: rotate(54deg);
    transform: rotate(54deg);
  }

  .c100.p16 .bar {
    -moz-transform: rotate(57.6deg);
    -ms-transform: rotate(57.6deg);
    -webkit-transform: rotate(57.6deg);
    transform: rotate(57.6deg);
  }

  .c100.p17 .bar {
    -moz-transform: rotate(61.2deg);
    -ms-transform: rotate(61.2deg);
    -webkit-transform: rotate(61.2deg);
    transform: rotate(61.2deg);
  }

  .c100.p18 .bar {
    -moz-transform: rotate(64.8deg);
    -ms-transform: rotate(64.8deg);
    -webkit-transform: rotate(64.8deg);
    transform: rotate(64.8deg);
  }

  .c100.p19 .bar {
    -moz-transform: rotate(68.4deg);
    -ms-transform: rotate(68.4deg);
    -webkit-transform: rotate(68.4deg);
    transform: rotate(68.4deg);
  }

  .c100.p20 .bar {
    -moz-transform: rotate(72deg);
    -ms-transform: rotate(72deg);
    -webkit-transform: rotate(72deg);
    transform: rotate(72deg);
  }

  .c100.p21 .bar {
    -moz-transform: rotate(75.6deg);
    -ms-transform: rotate(75.6deg);
    -webkit-transform: rotate(75.6deg);
    transform: rotate(75.6deg);
  }

  .c100.p22 .bar {
    -moz-transform: rotate(79.2deg);
    -ms-transform: rotate(79.2deg);
    -webkit-transform: rotate(79.2deg);
    transform: rotate(79.2deg);
  }

  .c100.p23 .bar {
    -moz-transform: rotate(82.8deg);
    -ms-transform: rotate(82.8deg);
    -webkit-transform: rotate(82.8deg);
    transform: rotate(82.8deg);
  }

  .c100.p24 .bar {
    -moz-transform: rotate(86.4deg);
    -ms-transform: rotate(86.4deg);
    -webkit-transform: rotate(86.4deg);
    transform: rotate(86.4deg);
  }

  .c100.p25 .bar {
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -webkit-transform: rotate(90deg);
    transform: rotate(90deg);
  }

  .c100.p26 .bar {
    -moz-transform: rotate(93.6deg);
    -ms-transform: rotate(93.6deg);
    -webkit-transform: rotate(93.6deg);
    transform: rotate(93.6deg);
  }

  .c100.p27 .bar {
    -moz-transform: rotate(97.2deg);
    -ms-transform: rotate(97.2deg);
    -webkit-transform: rotate(97.2deg);
    transform: rotate(97.2deg);
  }

  .c100.p28 .bar {
    -moz-transform: rotate(100.8deg);
    -ms-transform: rotate(100.8deg);
    -webkit-transform: rotate(100.8deg);
    transform: rotate(100.8deg);
  }

  .c100.p29 .bar {
    -moz-transform: rotate(104.4deg);
    -ms-transform: rotate(104.4deg);
    -webkit-transform: rotate(104.4deg);
    transform: rotate(104.4deg);
  }

  .c100.p30 .bar {
    -moz-transform: rotate(108deg);
    -ms-transform: rotate(108deg);
    -webkit-transform: rotate(108deg);
    transform: rotate(108deg);
  }

  .c100.p31 .bar {
    -moz-transform: rotate(111.6deg);
    -ms-transform: rotate(111.6deg);
    -webkit-transform: rotate(111.6deg);
    transform: rotate(111.6deg);
  }

  .c100.p32 .bar {
    -moz-transform: rotate(115.2deg);
    -ms-transform: rotate(115.2deg);
    -webkit-transform: rotate(115.2deg);
    transform: rotate(115.2deg);
  }

  .c100.p33 .bar {
    -moz-transform: rotate(118.8deg);
    -ms-transform: rotate(118.8deg);
    -webkit-transform: rotate(118.8deg);
    transform: rotate(118.8deg);
  }

  .c100.p34 .bar {
    -moz-transform: rotate(122.4deg);
    -ms-transform: rotate(122.4deg);
    -webkit-transform: rotate(122.4deg);
    transform: rotate(122.4deg);
  }

  .c100.p35 .bar {
    -moz-transform: rotate(126deg);
    -ms-transform: rotate(126deg);
    -webkit-transform: rotate(126deg);
    transform: rotate(126deg);
  }

  .c100.p36 .bar {
    -moz-transform: rotate(129.6deg);
    -ms-transform: rotate(129.6deg);
    -webkit-transform: rotate(129.6deg);
    transform: rotate(129.6deg);
  }

  .c100.p37 .bar {
    -moz-transform: rotate(133.2deg);
    -ms-transform: rotate(133.2deg);
    -webkit-transform: rotate(133.2deg);
    transform: rotate(133.2deg);
  }

  .c100.p38 .bar {
    -moz-transform: rotate(136.8deg);
    -ms-transform: rotate(136.8deg);
    -webkit-transform: rotate(136.8deg);
    transform: rotate(136.8deg);
  }

  .c100.p39 .bar {
    -moz-transform: rotate(140.4deg);
    -ms-transform: rotate(140.4deg);
    -webkit-transform: rotate(140.4deg);
    transform: rotate(140.4deg);
  }

  .c100.p40 .bar {
    -moz-transform: rotate(144deg);
    -ms-transform: rotate(144deg);
    -webkit-transform: rotate(144deg);
    transform: rotate(144deg);
  }

  .c100.p41 .bar {
    -moz-transform: rotate(147.6deg);
    -ms-transform: rotate(147.6deg);
    -webkit-transform: rotate(147.6deg);
    transform: rotate(147.6deg);
  }

  .c100.p42 .bar {
    -moz-transform: rotate(151.2deg);
    -ms-transform: rotate(151.2deg);
    -webkit-transform: rotate(151.2deg);
    transform: rotate(151.2deg);
  }

  .c100.p43 .bar {
    -moz-transform: rotate(154.8deg);
    -ms-transform: rotate(154.8deg);
    -webkit-transform: rotate(154.8deg);
    transform: rotate(154.8deg);
  }

  .c100.p44 .bar {
    -moz-transform: rotate(158.4deg);
    -ms-transform: rotate(158.4deg);
    -webkit-transform: rotate(158.4deg);
    transform: rotate(158.4deg);
  }

  .c100.p45 .bar {
    -moz-transform: rotate(162deg);
    -ms-transform: rotate(162deg);
    -webkit-transform: rotate(162deg);
    transform: rotate(162deg);
  }

  .c100.p46 .bar {
    -moz-transform: rotate(165.6deg);
    -ms-transform: rotate(165.6deg);
    -webkit-transform: rotate(165.6deg);
    transform: rotate(165.6deg);
  }

  .c100.p47 .bar {
    -moz-transform: rotate(169.2deg);
    -ms-transform: rotate(169.2deg);
    -webkit-transform: rotate(169.2deg);
    transform: rotate(169.2deg);
  }

  .c100.p48 .bar {
    -moz-transform: rotate(172.8deg);
    -ms-transform: rotate(172.8deg);
    -webkit-transform: rotate(172.8deg);
    transform: rotate(172.8deg);
  }

  .c100.p49 .bar {
    -moz-transform: rotate(176.4deg);
    -ms-transform: rotate(176.4deg);
    -webkit-transform: rotate(176.4deg);
    transform: rotate(176.4deg);
  }

  .c100.p50 .bar {
    -moz-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
  }

  .c100.p51 .bar {
    -moz-transform: rotate(183.6deg);
    -ms-transform: rotate(183.6deg);
    -webkit-transform: rotate(183.6deg);
    transform: rotate(183.6deg);
  }

  .c100.p52 .bar {
    -moz-transform: rotate(187.2deg);
    -ms-transform: rotate(187.2deg);
    -webkit-transform: rotate(187.2deg);
    transform: rotate(187.2deg);
  }

  .c100.p53 .bar {
    -moz-transform: rotate(190.8deg);
    -ms-transform: rotate(190.8deg);
    -webkit-transform: rotate(190.8deg);
    transform: rotate(190.8deg);
  }

  .c100.p54 .bar {
    -moz-transform: rotate(194.4deg);
    -ms-transform: rotate(194.4deg);
    -webkit-transform: rotate(194.4deg);
    transform: rotate(194.4deg);
  }

  .c100.p55 .bar {
    -moz-transform: rotate(198deg);
    -ms-transform: rotate(198deg);
    -webkit-transform: rotate(198deg);
    transform: rotate(198deg);
  }

  .c100.p56 .bar {
    -moz-transform: rotate(201.6deg);
    -ms-transform: rotate(201.6deg);
    -webkit-transform: rotate(201.6deg);
    transform: rotate(201.6deg);
  }

  .c100.p57 .bar {
    -moz-transform: rotate(205.2deg);
    -ms-transform: rotate(205.2deg);
    -webkit-transform: rotate(205.2deg);
    transform: rotate(205.2deg);
  }

  .c100.p58 .bar {
    -moz-transform: rotate(208.8deg);
    -ms-transform: rotate(208.8deg);
    -webkit-transform: rotate(208.8deg);
    transform: rotate(208.8deg);
  }

  .c100.p59 .bar {
    -moz-transform: rotate(212.4deg);
    -ms-transform: rotate(212.4deg);
    -webkit-transform: rotate(212.4deg);
    transform: rotate(212.4deg);
  }

  .c100.p60 .bar {
    -moz-transform: rotate(216deg);
    -ms-transform: rotate(216deg);
    -webkit-transform: rotate(216deg);
    transform: rotate(216deg);
  }

  .c100.p61 .bar {
    -moz-transform: rotate(219.6deg);
    -ms-transform: rotate(219.6deg);
    -webkit-transform: rotate(219.6deg);
    transform: rotate(219.6deg);
  }

  .c100.p62 .bar {
    -moz-transform: rotate(223.2deg);
    -ms-transform: rotate(223.2deg);
    -webkit-transform: rotate(223.2deg);
    transform: rotate(223.2deg);
  }

  .c100.p63 .bar {
    -moz-transform: rotate(226.8deg);
    -ms-transform: rotate(226.8deg);
    -webkit-transform: rotate(226.8deg);
    transform: rotate(226.8deg);
  }

  .c100.p64 .bar {
    -moz-transform: rotate(230.4deg);
    -ms-transform: rotate(230.4deg);
    -webkit-transform: rotate(230.4deg);
    transform: rotate(230.4deg);
  }

  .c100.p65 .bar {
    -moz-transform: rotate(234deg);
    -ms-transform: rotate(234deg);
    -webkit-transform: rotate(234deg);
    transform: rotate(234deg);
  }

  .c100.p66 .bar {
    -moz-transform: rotate(237.6deg);
    -ms-transform: rotate(237.6deg);
    -webkit-transform: rotate(237.6deg);
    transform: rotate(237.6deg);
  }

  .c100.p67 .bar {
    -moz-transform: rotate(241.2deg);
    -ms-transform: rotate(241.2deg);
    -webkit-transform: rotate(241.2deg);
    transform: rotate(241.2deg);
  }

  .c100.p68 .bar {
    -moz-transform: rotate(244.8deg);
    -ms-transform: rotate(244.8deg);
    -webkit-transform: rotate(244.8deg);
    transform: rotate(244.8deg);
  }

  .c100.p69 .bar {
    -moz-transform: rotate(248.4deg);
    -ms-transform: rotate(248.4deg);
    -webkit-transform: rotate(248.4deg);
    transform: rotate(248.4deg);
  }

  .c100.p70 .bar {
    -moz-transform: rotate(252deg);
    -ms-transform: rotate(252deg);
    -webkit-transform: rotate(252deg);
    transform: rotate(252deg);
  }

  .c100.p71 .bar {
    -moz-transform: rotate(255.6deg);
    -ms-transform: rotate(255.6deg);
    -webkit-transform: rotate(255.6deg);
    transform: rotate(255.6deg);
  }

  .c100.p72 .bar {
    -moz-transform: rotate(259.2deg);
    -ms-transform: rotate(259.2deg);
    -webkit-transform: rotate(259.2deg);
    transform: rotate(259.2deg);
  }

  .c100.p73 .bar {
    -moz-transform: rotate(262.8deg);
    -ms-transform: rotate(262.8deg);
    -webkit-transform: rotate(262.8deg);
    transform: rotate(262.8deg);
  }

  .c100.p74 .bar {
    -moz-transform: rotate(266.4deg);
    -ms-transform: rotate(266.4deg);
    -webkit-transform: rotate(266.4deg);
    transform: rotate(266.4deg);
  }

  .c100.p75 .bar {
    -moz-transform: rotate(270deg);
    -ms-transform: rotate(270deg);
    -webkit-transform: rotate(270deg);
    transform: rotate(270deg);
  }

  .c100.p76 .bar {
    -moz-transform: rotate(273.6deg);
    -ms-transform: rotate(273.6deg);
    -webkit-transform: rotate(273.6deg);
    transform: rotate(273.6deg);
  }

  .c100.p77 .bar {
    -moz-transform: rotate(277.2deg);
    -ms-transform: rotate(277.2deg);
    -webkit-transform: rotate(277.2deg);
    transform: rotate(277.2deg);
  }

  .c100.p78 .bar {
    -moz-transform: rotate(280.8deg);
    -ms-transform: rotate(280.8deg);
    -webkit-transform: rotate(280.8deg);
    transform: rotate(280.8deg);
  }

  .c100.p79 .bar {
    -moz-transform: rotate(284.4deg);
    -ms-transform: rotate(284.4deg);
    -webkit-transform: rotate(284.4deg);
    transform: rotate(284.4deg);
  }

  .c100.p80 .bar {
    -moz-transform: rotate(288deg);
    -ms-transform: rotate(288deg);
    -webkit-transform: rotate(288deg);
    transform: rotate(288deg);
  }

  .c100.p81 .bar {
    -moz-transform: rotate(291.6deg);
    -ms-transform: rotate(291.6deg);
    -webkit-transform: rotate(291.6deg);
    transform: rotate(291.6deg);
  }

  .c100.p82 .bar {
    -moz-transform: rotate(295.2deg);
    -ms-transform: rotate(295.2deg);
    -webkit-transform: rotate(295.2deg);
    transform: rotate(295.2deg);
  }

  .c100.p83 .bar {
    -moz-transform: rotate(298.8deg);
    -ms-transform: rotate(298.8deg);
    -webkit-transform: rotate(298.8deg);
    transform: rotate(298.8deg);
  }

  .c100.p84 .bar {
    -moz-transform: rotate(302.4deg);
    -ms-transform: rotate(302.4deg);
    -webkit-transform: rotate(302.4deg);
    transform: rotate(302.4deg);
  }

  .c100.p85 .bar {
    -moz-transform: rotate(306deg);
    -ms-transform: rotate(306deg);
    -webkit-transform: rotate(306deg);
    transform: rotate(306deg);
  }

  .c100.p86 .bar {
    -moz-transform: rotate(309.6deg);
    -ms-transform: rotate(309.6deg);
    -webkit-transform: rotate(309.6deg);
    transform: rotate(309.6deg);
  }

  .c100.p87 .bar {
    -moz-transform: rotate(313.2deg);
    -ms-transform: rotate(313.2deg);
    -webkit-transform: rotate(313.2deg);
    transform: rotate(313.2deg);
  }

  .c100.p88 .bar {
    -moz-transform: rotate(316.8deg);
    -ms-transform: rotate(316.8deg);
    -webkit-transform: rotate(316.8deg);
    transform: rotate(316.8deg);
  }

  .c100.p89 .bar {
    -moz-transform: rotate(320.4deg);
    -ms-transform: rotate(320.4deg);
    -webkit-transform: rotate(320.4deg);
    transform: rotate(320.4deg);
  }

  .c100.p90 .bar {
    -moz-transform: rotate(324deg);
    -ms-transform: rotate(324deg);
    -webkit-transform: rotate(324deg);
    transform: rotate(324deg);
  }

  .c100.p91 .bar {
    -moz-transform: rotate(327.6deg);
    -ms-transform: rotate(327.6deg);
    -webkit-transform: rotate(327.6deg);
    transform: rotate(327.6deg);
  }

  .c100.p92 .bar {
    -moz-transform: rotate(331.2deg);
    -ms-transform: rotate(331.2deg);
    -webkit-transform: rotate(331.2deg);
    transform: rotate(331.2deg);
  }

  .c100.p93 .bar {
    -moz-transform: rotate(334.8deg);
    -ms-transform: rotate(334.8deg);
    -webkit-transform: rotate(334.8deg);
    transform: rotate(334.8deg);
  }

  .c100.p94 .bar {
    -moz-transform: rotate(338.4deg);
    -ms-transform: rotate(338.4deg);
    -webkit-transform: rotate(338.4deg);
    transform: rotate(338.4deg);
  }

  .c100.p95 .bar {
    -moz-transform: rotate(342deg);
    -ms-transform: rotate(342deg);
    -webkit-transform: rotate(342deg);
    transform: rotate(342deg);
  }

  .c100.p96 .bar {
    -moz-transform: rotate(345.6deg);
    -ms-transform: rotate(345.6deg);
    -webkit-transform: rotate(345.6deg);
    transform: rotate(345.6deg);
  }

  .c100.p97 .bar {
    -moz-transform: rotate(349.2deg);
    -ms-transform: rotate(349.2deg);
    -webkit-transform: rotate(349.2deg);
    transform: rotate(349.2deg);
  }

  .c100.p98 .bar {
    -moz-transform: rotate(352.8deg);
    -ms-transform: rotate(352.8deg);
    -webkit-transform: rotate(352.8deg);
    transform: rotate(352.8deg);
  }

  .c100.p99 .bar {
    -moz-transform: rotate(356.4deg);
    -ms-transform: rotate(356.4deg);
    -webkit-transform: rotate(356.4deg);
    transform: rotate(356.4deg);
  }

  .c100.p100 .bar {
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }

  .c100:hover {
    cursor: default;
  }

  .c100:hover>span {
    width: 20px;
    line-height: 20px;
    font-size: 14pt;
    color: #3c4761;
  }

  .c100:hover:after {
    top: 0.07em;
    left: 0.07em;
    width: 0.86em;
    height: 0.86em;
  }

  .c100.blue .bar,
  .c100.blue .fill {
    border-color: #30bae7 !important;
  }

  .c100.blue:hover>span {
    color: #3c4761;
  }

  .c100.pink .bar,
  .c100.pink .fill {
    border-color: #d74680 !important;
  }

  .c100.pink:hover>span {
    color: #3c4761;
  }

  .c100.green .bar,
  .c100.green .fill {
    border-color: #15c7a8 !important;
  }

  .c100.green:hover>span {
    color: #3c4761;
  }

  .c100.orange .bar,
  .c100.orange .fill {
    border-color: #eb7d4b !important;
  }

  .c100.orange:hover>span {
    color: #3c4761;
  }

  .circle1 {
    width: 50px;
    margin-left: -30px;
  }
</style>

<section class="content">
  <div class="row">
    <div class="col-sm-3">
      <div class="mycard mb-3 col-12">
        <p class="card-title">Penyerapan Per Vendor</p>
        <div id="penyerapan_js"></div>
      </div>
      <div class="mycard mb-3 col-12">
        <p class="card-title">PO Divisi By Total Volume</p>
        <figure class="highcharts-figure">
          <div id="podivisibar"></div>
        </figure>
      </div>
      <div class="mycard mb-3 col-12">
        <p class="card-title">Top 5 Project</p>
        <figure class="highcharts-figure">
          <div id="top5project"></div>
        </figure>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="mycard mb-3 col-12">
        <p class="card-title text-center">Total Nilai Transportasi</p>
        <div id="total_nilai_trans"></div>
        <p class="card-text text-center">
          <p id="total_berat_1"></p>
        </p>
      </div>
      <div class="mycard mb-3 col-12">
        <div class="card">
          <div id="mapid"></div>
        </div>
      </div>
      <div class="mycard mb-3 col-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs pull-right">
            <li class="pull-left">Total Volume</li>
            <div class="pull-right">
              <div style="margin-bottom: 5px;">
                <select id="volume_bulan_ini_bulan" onchange="App.getDataDashboard()" style="display: none;">
                  <option value="" disabled>Pilih Bulan</option>
                  <?php
                  $now = date('m');
                  foreach ($bulan as $id => $v) {
                  ?>
                    <option value="<?= $id ?>" <?= $now == $id ? 'selected' : '' ?>><?= $v ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>
          </ul>
          <div class="tab-content no-padding">
            <figure class="highcharts-figure text-center">
              <div id="dailyvolumearea"></div>
            </figure>
          </div>
        </div>

      </div>
    </div>
    <div class="col-sm-3">
      <div class="mycard mb-3 col-12">
        <ul class="nav nav-tabs">
          <li>Jumlah Pemesanan </li>
          <div style="width: 100px; margin-bottom: 10px;">
            <select id="jumlah_pemesanan_bulan" onchange="App.getDataDashboard()" style="display: none">
              <option value="" disabled>Pilih Bulan</option>
              <?php
              $now = date('m');
              foreach ($bulan as $id => $v) {
              ?>
                <option value="<?= $id ?>" <?= $now == $id ? 'selected' : '' ?>><?= $v ?></option>
              <?php
              }
              ?>
            </select>
          </div>
        </ul>
        <div class="circle1">
          <div id="bulanini"></div>
          <div id="tahunini"></div>
          <p class="card-text text-wihte">-</p>
        </div>
      </div>

      <div class="mycard mb-3 col-12">
        <p class="card-title text-center">PO Divisi By Total Volume</p>
        <figure class="highcharts-figure">
          <div id="podivisipie"></div>
        </figure>
      </div>

      <div class="mycard mb-3 col-12">
        <p class="card-title text-center">Top 3 Vehicle</p>
        <div id="vehiclelist"></div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width:900px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pull-left" id="modal_title">Modal title</h5>
        <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="modal_body"></div>
      </div>
    </div>
  </div>
</div>

<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
<script type="text/javascript">
  var mymap = L.map('mapid').setView([-0.7031073524364783, 117.46582031250001], 4);

  L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoicmF6eWlkNzIiLCJhIjoiY2s1Z2g1Z3NvMDc0YTNmcGVubmgzd2l5bCJ9.6jAMfgoFlE4HVP-BYqEFPw'
  }).addTo(mymap);
</script>

<script data-main="<?php echo base_url() ?>assets/js/main/main-dashboard_transportasi" src="<?php echo base_url() ?>assets/js/require.js"></script>
