<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_master_data_category_spec extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {

        // begin
        $data = array(
            array(
                'code' => 'A4',
                'name' => 'SEMEN',
                'is_margis' => 1,
                'created_by' => 1,
                'specification' => array(
                    array(
                        'code' => '1',
                        'name' => 'Semen Portland Pozzoland Cement  ( PPC )',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Fiber cement Wave Walls (non asbestos)'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Fiber cement Wave Roof (non asbestos)'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Fiber cement Wave Roof (non asbestos)'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'Semen Type I (50 Kg)'
                            ),
                            array(
                                'code' => '005',
                                'name' => 'Atterberg Limits'
                            ),
                            array(
                                'code' => '006',
                                'name' => 'Semen PC 50 Kg'
                            ),
                            array(
                                'code' => '007',
                                'name' => 'Cement Portland'
                            ),
                        ),
                    ),
                    array(
                        'code' => '2',
                        'name' => 'Semen Ordinary Portland Cement (OPC), Tyoe I, II, III, IV dan V',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Semen Type I (40 Kg)'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Semen Type I (50 Kg)'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Semen 50kg Holcim'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'Semen Type V'
                            ),
                        ),
                    ),
                    array(
                        'code' => '3',
                        'name' => 'Semen Portland Putih',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Conbextra GP'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Cement Grouting (Conbextra GP)@25kg/bag'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Cement Grouting (incl. Mat.)'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'Cement Injection to soil Works'
                            ),
                            array(
                                'code' => '005',
                                'name' => 'Precast Portland Cement Concrete Curb'
                            ),
                            array(
                                'code' => '006',
                                'name' => 'MasterLife SF100'
                            ),
                            array(
                                'code' => '007',
                                'name' => 'Semen Putih'
                            ),
                            array(
                                'code' => '008',
                                'name' => 'Thenolith 15 mm 2 muka'
                            ),
                            array(
                                'code' => '009',
                                'name' => 'Curb'
                            ),
                        ),
                    ),
                    array(
                        'code' => '4',
                        'name' => 'Semen Berwarna',
                        'created_by' => 1,
                        'size' => array(

                        ),
                    ),
                    array(
                        'code' => '5',
                        'name' => 'Semen Instant Atau Mortar Instant',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Concrete Bounding Agent Sicadur 732'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Mortar Cemen Type I'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Mortar Cemen Type V'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'Mortar Screed'
                            ),
                            array(
                                'code' => '005',
                                'name' => 'Mortar Screed'
                            ),
                            array(
                                'code' => '006',
                                'name' => 'Mortar Cemen Type I'
                            ),
                            array(
                                'code' => '007',
                                'name' => 'Mortar Cemen Type V'
                            ),
                            array(
                                'code' => '008',
                                'name' => 'Mortar Screed'
                            ),
                            array(
                                'code' => '009',
                                'name' => 'Plesteran dan Acian'
                            ),
                            array(
                                'code' => '010',
                                'name' => 'Screed'
                            ),
                            array(
                                'code' => '011',
                                'name' => 'Adukan/Mortar 1PC : 3Ps'
                            ),
                            array(
                                'code' => '012',
                                'name' => 'Mahkota Ornamen'
                            ),
                            array(
                                'code' => '013',
                                'name' => 'Pagar Wiremesh'
                            ),
                            array(
                                'code' => '014',
                                'name' => 'Ornamen Barier'
                            ),
                            array(
                                'code' => '015',
                                'name' => 'Pot Bunga Beton'
                            ),
                            array(
                                'code' => '016',
                                'name' => 'Prasasti Jembatan'
                            ),
                        ),
                    ),
                    array(
                        'code' => '6',
                        'name' => 'Semen Portland Campur',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Gutter'
                            ),
                        ),
                    ),
                    array(
                        'code' => '7',
                        'name' => 'Semen Masonry',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Aerated concrete masonry'
                            ),
                        ),
                    ),
                ),
            ),
            array(
                'code' => 'A5',
                'name' => 'READYMIX CONCRETE',
                'is_margis' => 1,
                'created_by' => 1,
                'specification' => array(
                    array(
                        'code' => '1',
                        'name' => 'Beton Readymix Fly Ash 1',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Readymix FS45 FA'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Readymix K100 FA'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Readymix K125 FA'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'Readymix K150 FA'
                            ),
                            array(
                                'code' => '005',
                                'name' => 'Beton Ready Mix B-0'
                            ),
                            array(
                                'code' => '006',
                                'name' => 'Beton Class P'
                            ),
                            array(
                                'code' => '007',
                                'name' => 'Beton Ready Mix B-0'
                            ),
                            array(
                                'code' => '008',
                                'name' => 'Beton Ready mix fs = 45 Mpa'
                            ),
                            array(
                                'code' => '009',
                                'name' => 'Concrete fc=10 type I'
                            ),
                            array(
                                'code' => '010',
                                'name' => 'Concrete Grade K150 Cement Type I'
                            ),
                            array(
                                'code' => '011',
                                'name' => 'Concrete Grade K150 Cement Type I + SF'
                            ),
                            array(
                                'code' => '012',
                                'name' => 'Concrete Grade K150 Cement Type V'
                            ),
                            array(
                                'code' => '013',
                                'name' => 'Lantai kerja K-125'
                            ),
                            array(
                                'code' => '014',
                                'name' => 'Lean Concrete Type I'
                            ),
                            array(
                                'code' => '015',
                                'name' => 'Ready Mix Fc 15 Cement Type I'
                            ),
                            array(
                                'code' => '016',
                                'name' => 'Ready Mix Fc 25 Cement Type I'
                            ),
                            array(
                                'code' => '017',
                                'name' => 'Ready Mix Fc=125 Kg/m2 Cement Type I'
                            ),
                            array(
                                'code' => '018',
                                'name' => 'Ready Mix Fc-10 Cement Type I'
                            ),
                            array(
                                'code' => '019',
                                'name' => 'Ready Mix Fc-15 Cement Type I'
                            ),
                            array(
                                'code' => '020',
                                'name' => 'Ready Mix Fc-15 Cement Type II'
                            ),
                            array(
                                'code' => '021',
                                'name' => 'Ready Mix Fc-18 Cement Type II'
                            ),
                        ),
                    ),
                    array(
                        'code' => '2',
                        'name' => 'Beton Readymix Non Fly Ash 1',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Readymix LC50 NFA'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Readymix FS125 NFA'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Readymix FS45 NFA'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'Readymix FS50 NFA'
                            ),
                            array(
                                'code' => '005',
                                'name' => 'Readymix K100 NFA'
                            ),
                            array(
                                'code' => '006',
                                'name' => 'Readymix K125 NFA'
                            ),
                            array(
                                'code' => '007',
                                'name' => 'Readymix K150 NFA'
                            ),
                            array(
                                'code' => '008',
                                'name' => 'Ready Mix K150, Cement Type I'
                            ),
                            array(
                                'code' => '009',
                                'name' => 'Ready Mix K200, Cement Type I'
                            ),
                            array(
                                'code' => '010',
                                'name' => 'Ready Mix K250, Cement Type I'
                            ),
                            array(
                                'code' => '011',
                                'name' => 'Ready Mix Fc-30 Cement Type I'
                            ),
                            array(
                                'code' => '012',
                                'name' => 'Ready Mix K300, Cement Type I'
                            ),
                            array(
                                'code' => '013',
                                'name' => 'Ready Mix K350, Cement Type I'
                            ),
                            array(
                                'code' => '014',
                                'name' => 'Ready Mix K400, Cement Type I'
                            ),
                            array(
                                'code' => '015',
                                'name' => 'Ready Mix Fc-30 Screening Cement Type I'
                            ),
                            array(
                                'code' => '016',
                                'name' => 'Ready Mix Fc-20 PC I, klm praktis+form work'
                            ),
                            array(
                                'code' => '017',
                                'name' => 'Ready Mix Fc-35 Cement Type I'
                            ),
                            array(
                                'code' => '018',
                                'name' => 'Lean Concrete (f c 125 kg/cm2)'
                            ),
                        ),
                    ),
                    array(
                        'code' => '3',
                        'name' => 'Beton Readymix Non Fly Ash 2',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Readymix K175 NFA'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Readymix LC175 NFA'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Readymix K200 NFA'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'Readymix K225 NFA'
                            ),
                            array(
                                'code' => '005',
                                'name' => 'Readymix K250 NFA'
                            ),
                            array(
                                'code' => '006',
                                'name' => 'Ready Mix K400 Cement Type I+SF'
                            ),
                            array(
                                'code' => '007',
                                'name' => 'Ready Mix K150, Cement Type I+SF'
                            ),
                            array(
                                'code' => '008',
                                'name' => 'Ready Mix K200, Cement Type I+SF'
                            ),
                            array(
                                'code' => '009',
                                'name' => 'Ready Mix K250, Cement Type I+SF'
                            ),
                            array(
                                'code' => '010',
                                'name' => 'Ready Mix K300, Cement Type I+SF'
                            ),
                            array(
                                'code' => '011',
                                'name' => 'Ready Mix K350, Cement Type I+SF'
                            ),
                            array(
                                'code' => '012',
                                'name' => 'Ready Mix K400, Cement Type I+SF'
                            ),
                            array(
                                'code' => '013',
                                'name' => 'Ready Mix K400, Cement Type I+SF Slump 12+2'
                            ),
                            array(
                                'code' => '014',
                                'name' => 'Ready Mix K300 - I+SF+WP'
                            ),
                            array(
                                'code' => '015',
                                'name' => 'Ready Mix K350 - I+SF+WP'
                            ),
                            array(
                                'code' => '016',
                                'name' => 'Float Steam Trap'
                            ),
                            array(
                                'code' => '017',
                                'name' => 'Concrete Foundation'
                            ),
                            array(
                                'code' => '018',
                                'name' => 'Concrete Grade K200 Cement Type I'
                            ),
                            array(
                                'code' => '019',
                                'name' => 'Concrete Grade K250 Cement Type I'
                            ),
                            array(
                                'code' => '020',
                                'name' => 'Concrete Grade K200 Cement Type V'
                            ),
                            array(
                                'code' => '021',
                                'name' => 'Concrete Grade K250 Cement Type V'
                            ),
                            array(
                                'code' => '022',
                                'name' => 'Concrete Grade K200 Cement Type I + SF'
                            ),
                            array(
                                'code' => '023',
                                'name' => 'Concrete Grade K250 Cement Type I + SF'
                            ),
                            array(
                                'code' => '024',
                                'name' => 'Beton kelas C'
                            ),
                            array(
                                'code' => '025',
                                'name' => 'Beton kelas D'
                            ),
                            array(
                                'code' => '026',
                                'name' => 'Doket'
                            ),
                            array(
                                'code' => '027',
                                'name' => 'Beton Readymix Non Fly Ash 1 K 175 atau Klas E'
                            ),
                            array(
                                'code' => '028',
                                'name' => 'Beton Readymix Non Fly Ash 2 K 250atau fc 20 Mpa atau Klas C'
                            ),
                            array(
                                'code' => '029',
                                'name' => 'Beton K175 fc 14 53 Mpa'
                            ),
                            array(
                                'code' => '030',
                                'name' => 'Beton K250 fc 20 75 Mpa'
                            ),
                            array(
                                'code' => '031',
                                'name' => 'Beton Ready Mix Kelas C'
                            ),
                            array(
                                'code' => '032',
                                'name' => 'Beton ready Mix Kelas D'
                            ),
                        ),
                    ),
                    array(
                        'code' => '4',
                        'name' => 'Beton Readymix Non Fly Ash 5',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Readymix K275 NFA'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Readymix K300 NFA'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Readymix K300 NFA DS'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'Readymix K300 NFA SAL'
                            ),
                            array(
                                'code' => '005',
                                'name' => 'Readymix K300 NFA SF'
                            ),
                            array(
                                'code' => '006',
                                'name' => 'Readymix K300 NFA Type 5'
                            ),
                            array(
                                'code' => '007',
                                'name' => 'Readymix K350 NFA'
                            ),
                            array(
                                'code' => '008',
                                'name' => 'Readymix K350 NFA SF'
                            ),
                            array(
                                'code' => '009',
                                'name' => 'Readymix K400 NFA'
                            ),
                            array(
                                'code' => '010',
                                'name' => 'Readymix K400 NFA SF'
                            ),
                            array(
                                'code' => '011',
                                'name' => 'Readymix K400 NFA Type 5'
                            ),
                            array(
                                'code' => '012',
                                'name' => 'Readymix K450 NFA'
                            ),
                            array(
                                'code' => '013',
                                'name' => 'Ready Mix K150, Cement Type V'
                            ),
                            array(
                                'code' => '014',
                                'name' => 'Ready Mix K200, Cement Type V'
                            ),
                            array(
                                'code' => '015',
                                'name' => 'Ready Mix K250, Cement Type V'
                            ),
                            array(
                                'code' => '016',
                                'name' => 'Ready Mix K300, Cement Type V'
                            ),
                            array(
                                'code' => '017',
                                'name' => 'Ready Mix K350, Cement Type V'
                            ),
                            array(
                                'code' => '018',
                                'name' => 'Ready Mix K400, Cement Type V'
                            ),
                            array(
                                'code' => '019',
                                'name' => 'Ready Mix K300 - V+WP'
                            ),
                            array(
                                'code' => '020',
                                'name' => 'Ready Mix K400 - V'
                            ),
                            array(
                                'code' => '021',
                                'name' => 'Ready Mix K400 - V+WP'
                            ),
                            array(
                                'code' => '022',
                                'name' => 'Concrete Grade K300 Cement Type I'
                            ),
                            array(
                                'code' => '023',
                                'name' => 'Concrete Grade K350 Cement Type I'
                            ),
                            array(
                                'code' => '024',
                                'name' => 'Concrete Grade K400 Cement Type I'
                            ),
                            array(
                                'code' => '025',
                                'name' => 'Concrete Grade K300 Cement Type V'
                            ),
                            array(
                                'code' => '026',
                                'name' => 'Concrete Grade K350 Cement Type V'
                            ),
                            array(
                                'code' => '027',
                                'name' => 'Concrete Grade K400 Cement Type V'
                            ),
                            array(
                                'code' => '028',
                                'name' => 'Concrete Grade K300 Cement Type I + SF'
                            ),
                            array(
                                'code' => '029',
                                'name' => 'Concrete Grade K350 Cement Type I + SF'
                            ),
                            array(
                                'code' => '030',
                                'name' => 'Concrete Grade K400 Cement Type I + SF'
                            ),
                            array(
                                'code' => '031',
                                'name' => 'Readmix C25 (Type I)'
                            ),
                            array(
                                'code' => '032',
                                'name' => 'Readmix C25 (Type II)'
                            ),
                            array(
                                'code' => '033',
                                'name' => 'Readmix C30 (Type I)'
                            ),
                            array(
                                'code' => '034',
                                'name' => 'Readmix C30 (Type II)'
                            ),
                            array(
                                'code' => '035',
                                'name' => 'Readmix C30 (Type V)'
                            ),
                            array(
                                'code' => '036',
                                'name' => 'Beton Readymix K275'
                            ),
                            array(
                                'code' => '037',
                                'name' => 'Beton Readymix Non Fly Ash 2 K 350atau fc 30 Mpa atau Klas B'
                            ),
                            array(
                                'code' => '038',
                                'name' => 'Beton Readymix Non Fly Ash 2 K 350atau fc 30 Mpa atau Klas B bore pile'
                            ),
                            array(
                                'code' => '039',
                                'name' => 'Beton Readymix Non Fly Ash 2 K 400atau fc 40 Mpa atau Klas A'
                            ),
                            array(
                                'code' => '040',
                                'name' => 'Beton K350 fc 29 05 Mpa'
                            ),
                            array(
                                'code' => '041',
                                'name' => 'Beton ready Mix Kelas B-1'
                            ),
                            array(
                                'code' => '042',
                                'name' => 'Beton ready Mix Kelas B-2'
                            ),
                        ),
                    ),
                    array(
                        'code' => '5',
                        'name' => 'Beton Readymix Fly Ash 2',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Readymix K175 FA'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Readymix K225 FA'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Readymix K250 FA'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'Drainage'
                            ),
                        ),
                    ),
                    array(
                        'code' => '6',
                        'name' => 'Beton Readymix Fly Ash 5',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Readymix K300 FA'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Readymix K350 FA'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Readymix K400 FA'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'Readymix K500 FA'
                            ),
                            array(
                                'code' => '005',
                                'name' => 'Readymix K500 NFA'
                            ),
                            array(
                                'code' => '006',
                                'name' => 'Beton Ready Mix K.350 slump 12'
                            ),
                            array(
                                'code' => '007',
                                'name' => 'Beton Ready Mix K.350 slump 18'
                            ),
                            array(
                                'code' => '008',
                                'name' => 'Beton Ready Mix K.500 slump 12'
                            ),
                            array(
                                'code' => '009',
                                'name' => 'Beton kelas B'
                            ),
                            array(
                                'code' => '010',
                                'name' => 'Beton Ready Mix K.350 slump 12'
                            ),
                            array(
                                'code' => '011',
                                'name' => 'Beton Ready Mix K.350 slump 18'
                            ),
                            array(
                                'code' => '012',
                                'name' => 'Beton Ready Mix K.500 slump 12'
                            ),
                            array(
                                'code' => '013',
                                'name' => 'Beton Readymix Non Fly Ash 1 K 500atau fc 42 Mpa'
                            ),
                            array(
                                'code' => '014',
                                'name' => 'Floor'
                            ),
                            array(
                                'code' => '015',
                                'name' => 'PHT Piles dia. 400mm'
                            ),
                            array(
                                'code' => '016',
                                'name' => 'PHT Piles dia. 600mm'
                            ),
                            array(
                                'code' => '017',
                                'name' => 'Ready Mix Cement Mortar'
                            ),
                            array(
                                'code' => '018',
                                'name' => 'Ready Mix Fc-15 Cement Type V'
                            ),
                            array(
                                'code' => '019',
                                'name' => 'Ready Mix Fc-20 Cement Type II'
                            ),
                            array(
                                'code' => '020',
                                'name' => 'Ready Mix Fc-20 Cement Type V'
                            ),
                            array(
                                'code' => '021',
                                'name' => 'Ready Mix Fc-20 PC I, klm praktis+form work'
                            ),
                            array(
                                'code' => '022',
                                'name' => 'Ready Mix Fc-25 Cement Type I'
                            ),
                            array(
                                'code' => '023',
                                'name' => 'Ready Mix Fc-25 Cement Type II'
                            ),
                            array(
                                'code' => '024',
                                'name' => 'Ready Mix Fc-25 Cement Type V'
                            ),
                            array(
                                'code' => '025',
                                'name' => 'Ready Mix Fc-28 Cement Type II'
                            ),
                            array(
                                'code' => '026',
                                'name' => 'Ready Mix Fc-30 Cement Type I'
                            ),
                            array(
                                'code' => '027',
                                'name' => 'Ready Mix Fc-30 Cement Type I'
                            ),
                            array(
                                'code' => '028',
                                'name' => 'Ready Mix Fc-30 Cement Type II'
                            ),
                            array(
                                'code' => '029',
                                'name' => 'Ready Mix Fc-30 Cement Type V'
                            ),
                            array(
                                'code' => '030',
                                'name' => 'Ready Mix Fc-35 Cement Type I'
                            ),
                            array(
                                'code' => '031',
                                'name' => 'Ready Mix Fc-35 Cement Type II'
                            ),
                            array(
                                'code' => '032',
                                'name' => 'Readymix K-175'
                            ),
                            array(
                                'code' => '033',
                                'name' => 'Readymix K-350'
                            ),
                            array(
                                'code' => '034',
                                'name' => 'Rigid pavement K.300, t=15 cm'
                            ),
                            array(
                                'code' => '035',
                                'name' => 'Rigid pavement K.300, t=15 cm'
                            ),
                        ),
                    ),
                    array(
                        'code' => '7',
                        'name' => 'Beton Readymix Aditive (Khusus) Type 1',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Ready Mix K-350, Cement Type I/OPC'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Ready Mix K-300, Cement Type I/OPC'
                            ),
                        ),
                    ),
                    array(
                        'code' => '8',
                        'name' => 'Beton Readymix Aditive (Khusus) Type 2',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Ready Mix Cement Mortar'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Ready Mix Fc-25 Cement Type I'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Ready Mix Fc-35 Cement Type I'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'Ready Mix K-150, Cement Type II/PCC'
                            ),
                            array(
                                'code' => '005',
                                'name' => 'Ready Mix K-300, Cement Type II PHT'
                            ),
                            array(
                                'code' => '006',
                                'name' => 'Ready Mix K-300, Cement Type II/PCC'
                            ),
                            array(
                                'code' => '007',
                                'name' => 'Ready Mix K-350, Cement Type II/PCC'
                            ),
                        ),
                    ),
                    array(
                        'code' => '9',
                        'name' => 'Beton Readymix Aditive (Khusus) Type 5',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Beton Readymix Non Fly Ash 1 K 500atau fc 42 Mpa Early Strenght'
                            ),
                        ),
                    ),
                    array(
                        'code' => 'A',
                        'name' => 'Beton Readymix Klas P',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Beton Readymix Non Fly Ash Klas P'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Beton Ready Mix Kelas P'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Beton kelas P'
                            ),
                        ),
                    ),
                    array(
                        'code' => 'B',
                        'name' => 'Dinding Pasangan-Beton Ringan',
                        'created_by' => 1,
                        'size' => array(

                        ),
                    ),
                    array(
                        'code' => 'C',
                        'name' => 'Readymix Mortar',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Shotcrete Material'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Mortar Screed'
                            ),
                        ),
                    ),
                    array(
                        'code' => 'D',
                        'name' => 'Readymix Mortar A',
                        'created_by' => 1,
                        'size' => array(

                        ),
                    ),
                    array(
                        'code' => 'E',
                        'name' => 'Readymix Type BB',
                        'created_by' => 1,
                        'size' => array(

                        ),
                    ),
                    array(
                        'code' => 'F',
                        'name' => 'Readymix Type CB',
                        'created_by' => 1,
                        'size' => array(

                        ),
                    ),
                    array(
                        'code' => 'G',
                        'name' => 'Readymix Type DB',
                        'created_by' => 1,
                        'size' => array(

                        ),
                    ),
                    array(
                        'code' => 'H',
                        'name' => 'Readymix Type EB',
                        'created_by' => 1,
                        'size' => array(

                        ),
                    ),
                    array(
                        'code' => 'I',
                        'name' => 'Readymix Type FB',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Ready Mix Fc 22 Cement Type I'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Ready Mix Fc 25 Cement Type II'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Ready Mix Fc 30 Cement Type I + silica fume 20 kg/m3 + master fibers 0.9kg/m3'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'Ready Mix Fc 30 Cement Type II + master fibers 0.9kg/m3'
                            ),
                            array(
                                'code' => '005',
                                'name' => 'Ready Mix Fc 30 Cement Type V'
                            ),
                            array(
                                'code' => '006',
                                'name' => 'Ready Mix Fc 30 Cement Type V + master fibers 0.9kg/m3'
                            ),
                        ),
                    ),
                    array(
                        'code' => 'J',
                        'name' => 'Readymix Type G',
                        'created_by' => 1,
                        'size' => array(

                        ),
                    ),
                    array(
                        'code' => 'K',
                        'name' => 'CTB',
                        'created_by' => 1,
                        'size' => array(

                        ),
                    ),
                ),
            ),
            array(
                'code' => 'AF',
                'name' => 'BAJA TULANGAN BETON / BESI BETON / REBAR ATAU REINFORCING BAR - KHR & SUS',
                'is_margis' => 1,
                'created_by' => 1,
                'specification' => array(
                    array(
                        'code' => '1',
                        'name' => 'Besi BetonUlir BJTS-40 (Diameter : 10,13,16,19,22,25,29,32,36,40 mm)',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Reinforcement Column'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Reinforcement Concrete Slab elev. +18.40'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Reinforcement Diaghfragma'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'Reinforcement Deckslab'
                            ),
                            array(
                                'code' => '005',
                                'name' => 'Tie back (deform bar 32mm)'
                            ),
                            array(
                                'code' => '006',
                                'name' => 'Angkur dia 50 mm'
                            ),
                            array(
                                'code' => '007',
                                'name' => 'Angkutan Baja Tulangan'
                            ),
                            array(
                                'code' => '008',
                                'name' => 'Baja Tulangan Polos'
                            ),
                            array(
                                'code' => '009',
                                'name' => 'Baja Tulangan Ulir'
                            ),
                            array(
                                'code' => '010',
                                'name' => 'Baja Tulangan ulir U32'
                            ),
                            array(
                                'code' => '011',
                                'name' => 'Baja Tulangan ulir U40'
                            ),
                            array(
                                'code' => '012',
                                'name' => 'Besi Beton ulir'
                            ),
                            array(
                                'code' => '013',
                                'name' => 'Besi Beton Ulir 2'
                            ),
                            array(
                                'code' => '014',
                                'name' => 'Besi Beton Ulir Diameter 10'
                            ),
                            array(
                                'code' => '015',
                                'name' => 'Besi Beton Ulir Diameter 12'
                            ),
                            array(
                                'code' => '016',
                                'name' => 'Besi Beton Ulir Diameter 13'
                            ),
                            array(
                                'code' => '017',
                                'name' => 'Besi Beton Ulir Diameter 16'
                            ),
                            array(
                                'code' => '018',
                                'name' => 'Besi Beton Ulir Diameter 19'
                            ),
                            array(
                                'code' => '019',
                                'name' => 'Besi Beton Ulir Diameter 22'
                            ),
                            array(
                                'code' => '020',
                                'name' => 'Besi Beton Ulir Diameter 25'
                            ),
                            array(
                                'code' => '021',
                                'name' => 'Besi Beton Ulir Diameter 29'
                            ),
                            array(
                                'code' => '022',
                                'name' => 'Besi Beton Ulir Diameter 32'
                            ),
                            array(
                                'code' => '023',
                                'name' => 'Besi Bore Pile'
                            ),
                            array(
                                'code' => '024',
                                'name' => 'Besi dia 10'
                            ),
                            array(
                                'code' => '025',
                                'name' => 'Besi dia 13'
                            ),
                            array(
                                'code' => '026',
                                'name' => 'Besi dia 16'
                            ),
                            array(
                                'code' => '027',
                                'name' => 'Besi dia 19'
                            ),
                            array(
                                'code' => '028',
                                'name' => 'Besi dia 22'
                            ),
                            array(
                                'code' => '029',
                                'name' => 'Besi dia 25'
                            ),
                            array(
                                'code' => '030',
                                'name' => 'Besi dia 29'
                            ),
                            array(
                                'code' => '031',
                                'name' => 'Besi dia 32'
                            ),
                            array(
                                'code' => '032',
                                'name' => 'Besi dia 6'
                            ),
                            array(
                                'code' => '033',
                                'name' => 'Besi dia 8'
                            ),
                            array(
                                'code' => '034',
                                'name' => 'Besi Polos diameter 10'
                            ),
                            array(
                                'code' => '035',
                                'name' => 'Besi Tulangan'
                            ),
                            array(
                                'code' => '036',
                                'name' => 'BESI ULIR DIA. 10 MM'
                            ),
                            array(
                                'code' => '037',
                                'name' => 'BESI ULIR DIA. 36 MM'
                            ),
                            array(
                                'code' => '038',
                                'name' => 'BESI ULIR DIA. 40 MM'
                            ),
                            array(
                                'code' => '039',
                                'name' => 'Crane 50 Ton'
                            ),
                            array(
                                'code' => '040',
                                'name' => 'Deformed Bar'
                            ),
                            array(
                                'code' => '041',
                                'name' => 'Deformed Bar + Transport'
                            ),
                            array(
                                'code' => '042',
                                'name' => 'Excavator'
                            ),
                            array(
                                'code' => '043',
                                'name' => 'PC Pile (400mm Dia)L=10m Bottom Class C'
                            ),
                            array(
                                'code' => '044',
                                'name' => 'Plain Bar'
                            ),
                            array(
                                'code' => '045',
                                'name' => 'Rebar'
                            ),
                            array(
                                'code' => '046',
                                'name' => 'Reinforcement Bar (Material)'
                            ),
                            array(
                                'code' => '047',
                                'name' => 'Sag Rod'
                            ),
                            array(
                                'code' => '048',
                                'name' => 'Tiang Pancang Pipa Baja dia 1000mm'
                            ),
                            array(
                                'code' => '049',
                                'name' => 'Tie back (deform bar 32mm)'
                            ),
                            array(
                                'code' => '050',
                                'name' => 'Tire roller'
                            ),
                        ),
                    ),
                    array(
                        'code' => '2',
                        'name' => 'Besi Beton Polos BJTP-24 (Diameter : 8,10,12 mm)',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Besi Beton Polos Diameter 8'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Besi Beton Polos Diameter 10'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Besi Beton Polos Diameter 12'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'PC Pile (400mm Dia)L=6m Middle Class C'
                            ),
                            array(
                                'code' => '005',
                                'name' => 'Plain Bar'
                            ),
                            array(
                                'code' => '006',
                                'name' => 'Dump Truck 5 Ton'
                            ),
                            array(
                                'code' => '007',
                                'name' => 'Besi beton polos atau ulir'
                            ),
                            array(
                                'code' => '008',
                                'name' => 'Besi Tulangan Terpasang'
                            ),
                            array(
                                'code' => '009',
                                'name' => 'Baja Tulangan polos U24'
                            ),
                        ),
                    ),
                    array(
                        'code' => '3',
                        'name' => 'PC Wire Atau PC Strand',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Strand tendon 0.6'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'PC Wireatau Strand dia. 0.6inch'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'Kabel Strand 12.7 mm'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'Kabel Strand 12.7 mm'
                            ),
                        ),
                    ),
                    array(
                        'code' => '4',
                        'name' => 'Kawat Bendrat',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Kawat Bendrat; Ex-China'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'As Drat 1/2" x 1m (Natural)'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'As Drat 1/2inch x 1m (Natural)'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'Bendrat'
                            ),
                            array(
                                'code' => '005',
                                'name' => 'Kawat Bendrat'
                            ),
                            array(
                                'code' => '006',
                                'name' => 'Kawat Bendrat; Ex-China'
                            ),
                            array(
                                'code' => '007',
                                'name' => 'Kawat Beton'
                            ),
                            array(
                                'code' => '008',
                                'name' => 'Kawat BWG'
                            ),
                            array(
                                'code' => '009',
                                'name' => 'Kawat Stainless Steel dia. 3, SS 316 (0.222 kg/m) - 3cmx3cm'
                            ),
                            array(
                                'code' => '010',
                                'name' => 'Rebar wire'
                            ),
                            array(
                                'code' => '011',
                                'name' => 'Wire Rope'
                            ),
                        ),
                    ),
                    array(
                        'code' => '5',
                        'name' => 'Dowel Bar',
                        'created_by' => 1,
                        'size' => array(
                            array(
                                'code' => '001',
                                'name' => 'Dowel Bar dia 25 L 1 m'
                            ),
                            array(
                                'code' => '002',
                                'name' => 'Reinforcing Bar U-39'
                            ),
                            array(
                                'code' => '003',
                                'name' => 'BESI D-19 LRT1'
                            ),
                            array(
                                'code' => '004',
                                'name' => 'BESI DIA 10'
                            ),
                            array(
                                'code' => '005',
                                'name' => 'BESI DIA 13'
                            ),
                            array(
                                'code' => '006',
                                'name' => 'BESI DIA 19'
                            ),
                            array(
                                'code' => '007',
                                'name' => 'BESI DIA 22'
                            ),
                            array(
                                'code' => '008',
                                'name' => 'BESI DIA 25'
                            ),
                            array(
                                'code' => '009',
                                'name' => 'BESI DIA 29'
                            ),
                            array(
                                'code' => '010',
                                'name' => 'BESI DIA 32'
                            ),
                            array(
                                'code' => '011',
                                'name' => 'BESI DIA 8'
                            ),
                            array(
                                'code' => '012',
                                'name' => 'Deformed Bar'
                            ),
                            array(
                                'code' => '013',
                                'name' => 'Deformed Bar Dowel'
                            ),
                            array(
                                'code' => '014',
                                'name' => 'Dowel Dia. 32'
                            ),
                            array(
                                'code' => '015',
                                'name' => 'PT Bar Dia. 32'
                            ),
                            array(
                                'code' => '016',
                                'name' => 'PVC Dowel'
                            ),
                            array(
                                'code' => '017',
                                'name' => 'Rebar for Dowel'
                            ),
                            array(
                                'code' => '018',
                                'name' => 'Reinforcing Bar U-39'
                            ),
                        ),
                    ),
                ),
            ),
        );

        $this->db->trans_start();

        foreach(['category','specification','size'] as $v)
        {
            $this->db->truncate($v);
        }

        foreach($data as $cat)
        {
            $data_cat = array(
                'code' => $cat['code'],
                'name' => $cat['name'],
                'is_margis' => 1,
                'created_by' => 1,
            );

            $this->db->insert('category', $data_cat);
            $id_cat = $this->db->insert_id();
            foreach($cat['specification'] as $spec)
            {
                $data_spec = array(
                    'code' => $spec['code'],
                    'name' => $spec['name'],
                    'category_id' => $id_cat,
                    'created_by' => 1,
                );
                $this->db->insert('specification', $data_spec);
                $id_spec = $this->db->insert_id();
                foreach($spec['size'] as $size)
                {
                    $data_size = array(
                        'code' => $size['code'],
                        'name' => $size['name'],
                        'specification_id' => $id_spec,
                        'default_weight' => 1,
                        'created_by' => 1,
                    );
                    $this->db->insert('size', $data_size);
                }
            }

        }
        //echo '<pre>';
        //print_r($this->db->queries);
        //echo '</pre>';
        $this->db->trans_complete();
        // end

        $category_help = array(
            array(
                "kode" => "A1",
                "name" => "TANAH DAN PRODUK DARI TANAH",
            ),
            array(
                "kode" => "A2",
                "name" => "PASIR & BATU-BATUAN",
            ),
            array(
                "kode" => "A3",
                "name" => "KAYU DAN PRODUK BAMBU",
            ),
            array(
                "kode" => "A6",
                "name" => "PRODUK BETON PRACETAK",
            ),
            array(
                "kode" => "A7",
                "name" => "KACA",
            ),
            array(
                "kode" => "A8",
                "name" => "GYPSUM BOARD, PLASTER BOARD, DAN PRODUKI TURUNAN GYPSUM LAINNYA",
            ),
            array(
                "kode" => "A9",
                "name" => "GRANIT / KERAMIK / PERALATAN KAMAR MANDI",
            ),
            array(
                "kode" => "AA",
                "name" => "SANITAIR",
            ),
            array(
                "kode" => "AB",
                "name" => "INSULASI",
            ),
            array(
                "kode" => "AC",
                "name" => "MATERIAL FINISHING – CAT, PELITUR, PERNIS, PROTECTIVE COATING",
            ),
            array(
                "kode" => "AD",
                "name" => "FURNITURE",
            ),
            array(
                "kode" => "AE",
                "name" => "FLORA",
            ),
            array(
                "kode" => "AG",
                "name" => "METAL NON FERROUS -KHR SUS",
            ),
            array(
                "kode" => "AH",
                "name" => "PRODUK MANUFAKTUR DAN FABRIKASI BAJA",
            ),
            array(
                "kode" => "AI",
                "name" => "ANEKA PRODUK KIMIA-BAS",
            ),
            array(
                "kode" => "AJ",
                "name" => "PRODUK PLASTIK/GEOTEXTILE",
            ),
            array(
                "kode" => "AK",
                "name" => "PRODUK KARET-SUS",
            ),
            array(
                "kode" => "AL",
                "name" => "BITUMEN/ASPHALT",
            ),
            array(
                "kode" => "AM",
                "name" => "MATERIAL MEKANIKAL",
            ),
            array(
                "kode" => "AN",
                "name" => "MINYAK DAN BAHAN BAKAR",
            ),
            array(
                "kode" => "AO",
                "name" => "MECHANICAL EQUIPMENT - ROTATING",
            ),
            array(
                "kode" => "AP",
                "name" => "MECHANICAL STATIC EQUIPMENT",
            ),
            array(
                "kode" => "AQ",
                "name" => "MEKANIKAL & ELEKTRIKAL-TATA UDARA, MESIN PENGATUR SUHU UDARA (AIR CONDITIONING MACHINES, AC),",
            ),
            array(
                "kode" => "AR",
                "name" => "MATERIAL- ELECTRICAL",
            ),
            array(
                "kode" => "AS",
                "name" => "MATERIAL INSTRUMENTASI & CONTROL SYSTEM",
            ),
            array(
                "kode" => "AT",
                "name" => "MECHANICAL TOOLS / MESIN PERKAKAS",
            ),
            array(
                "kode" => "AU",
                "name" => "MATERIAL BANTU",
            ),
        );

        $category_pk = [];

        $this->db->trans_start();
        foreach ($category_help as $v)
        {
            $data = [
                'code' => $v['kode'],
                'name' => $v['name'],
                'is_margis' => 1,
                'created_by' => 1,
            ];
            $this->db->insert('category', $data);
            $insert_id = $this->db->insert_id();
            $category_pk[$v['kode']] = $insert_id;
        }


        $specification_helper = array(
            array(
                "cat_code" => "A1",
                "spec_code" => "1",
                "name" => "Tanah Urug / tanah timbunan / tanah galian / tanah backfill (soil)",
            ),
            array(
                "cat_code" => "A1",
                "spec_code" => "2",
                "name" => "Tanah Rabuk",
            ),
            array(
                "cat_code" => "A1",
                "spec_code" => "3",
                "name" => "Batu Bata",
            ),
            array(
                "cat_code" => "A1",
                "spec_code" => "4",
                "name" => "Genteng Tanah Liat",
            ),
            array(
                "cat_code" => "A1",
                "spec_code" => "5",
                "name" => "Pipa Tanah Liat",
            ),
            array(
                "cat_code" => "A1",
                "spec_code" => "6",
                "name" => "Batako / Bata Tras / coneblock / pavingblock",
            ),
            array(
                "cat_code" => "A1",
                "spec_code" => "7",
                "name" => "Tanah Granular",
            ),
            array(
                "cat_code" => "A1",
                "spec_code" => "8",
                "name" => "Tanah Humus",
            ),
            array(
                "cat_code" => "A1",
                "spec_code" => "9",
                "name" => "Tanah Merah",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "1",
                "name" => "Pasir Urug",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "2",
                "name" => "Pasir Pasang",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "3",
                "name" => "Pasir Extra Beton",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "4",
                "name" => "Pasir  Beton",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "5",
                "name" => "Pasir Batu (Sirtu)",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "6",
                "name" => "Batu Kapur/ Tras",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "7",
                "name" => "Batu Kali",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "8",
                "name" => "Batu Gunung",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "9",
                "name" => "Batu Karang Laut",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "A",
                "name" => "Batu Pecah/Split",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "B",
                "name" => "Base Coarse",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "C",
                "name" => "Ballas",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "D",
                "name" => "Batu Bulat",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "E",
                "name" => "Sub Base Coarse",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "F",
                "name" => "Pasir Beton",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "G",
                "name" => "Abu Batu",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "H",
                "name" => "Batu Bronjong",
            ),
            array(
                "cat_code" => "A2",
                "spec_code" => "I",
                "name" => "Sand Bag",
            ),
            array(
                "cat_code" => "A3",
                "spec_code" => "1",
                "name" => "Kayu",
            ),
            array(
                "cat_code" => "A3",
                "spec_code" => "2",
                "name" => "Triplek/Mulktiplek",
            ),
            array(
                "cat_code" => "A3",
                "spec_code" => "3",
                "name" => "Cerucuk/Dolken",
            ),
            array(
                "cat_code" => "A3",
                "spec_code" => "4",
                "name" => "Produk Olahan Lainnya",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "1",
                "name" => "Paving Block",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "2",
                "name" => "Genteng Beton",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "3",
                "name" => "Buis Beton",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "4",
                "name" => "Pipa Beton (Concrete Pipe)",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "5",
                "name" => "Tiang Pancang Beton",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "6",
                "name" => "Beton Pracetak Slab",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "7",
                "name" => "Beton Pracetak Kolom",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "8",
                "name" => "Beton Pracetak Girder",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "C",
                "name" => "Beton Pracetak-Tangga",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "D",
                "name" => "Beton Pracetak -Car Stopper",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "E",
                "name" => "Beton Pracetak -Kansteen",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "F",
                "name" => "Beton Pracetak-Tiang Bendera",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "G",
                "name" => "Beton Pracetak-Corrugated Sheet Pile",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "H",
                "name" => "Beton Pracetak-Bantalan Jalan Kereta Api",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "I",
                "name" => "Beton Pracetak-Parapet",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "J",
                "name" => "Beton Pracetak- Movable Concrete Barrier (MCB)",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "K",
                "name" => "Fase, Fasad, Panel Beton  (Dinding Luar)",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "L",
                "name" => "Beton Pracetak-Saluran/box culvert",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "M",
                "name" => "Beton Pracetak-Precast Concrete Fence",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "N",
                "name" => "Beton Pracetak-Plat Pagar",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "O",
                "name" => "Beton Pracetak-Pemecah Ombak",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "P",
                "name" => "Beton Pracetak-Flat Concrete Sheet Pile",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "Q",
                "name" => "Beton Pracetak - Concrete Pole Atau Tiang Listrik",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "R",
                "name" => "Beton decking",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "S",
                "name" => "Beton Tie Beam",
            ),
            array(
                "cat_code" => "A6",
                "spec_code" => "T",
                "name" => "Beton Rabat Panel",
            ),
            array(
                "cat_code" => "A7",
                "spec_code" => "1",
                "name" => "Kaca Polos / Clear",
            ),
            array(
                "cat_code" => "A7",
                "spec_code" => "2",
                "name" => "Kaca Warna / Tinted / Rayben / Susu",
            ),
            array(
                "cat_code" => "A7",
                "spec_code" => "3",
                "name" => "Mirror / Cermin",
            ),
            array(
                "cat_code" => "A7",
                "spec_code" => "4",
                "name" => "Insulating Glass Unit",
            ),
            array(
                "cat_code" => "A7",
                "spec_code" => "5",
                "name" => "Kaca Dekoratif Atau Ornamental",
            ),
            array(
                "cat_code" => "A7",
                "spec_code" => "6",
                "name" => "Produk Dari Kaca Lainnya",
            ),
            array(
                "cat_code" => "A8",
                "spec_code" => "1",
                "name" => "Papan Gypsum",
            ),
            array(
                "cat_code" => "A8",
                "spec_code" => "2",
                "name" => "Kelengkapan Pemasangan Papan Gypsum",
            ),
            array(
                "cat_code" => "A9",
                "spec_code" => "1",
                "name" => "Granit Alam",
            ),
            array(
                "cat_code" => "A9",
                "spec_code" => "2",
                "name" => "Marmer",
            ),
            array(
                "cat_code" => "A9",
                "spec_code" => "3",
                "name" => "Homogenius Tile",
            ),
            array(
                "cat_code" => "A9",
                "spec_code" => "4",
                "name" => "Keramik",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "1",
                "name" => "Closet Jongkok",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "2",
                "name" => "Closet Duduk",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "3",
                "name" => "Wastafel",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "4",
                "name" => "Urinal",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "5",
                "name" => "Bath Tub",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "6",
                "name" => "Bak Mandi",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "7",
                "name" => "Tempat Sabun",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "8",
                "name" => "Floor Drain",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "9",
                "name" => "Kran Air",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "A",
                "name" => "Shower",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "B",
                "name" => "Jet Washer",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "C",
                "name" => "Bidet",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "D",
                "name" => "Kitchen Zink",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "E",
                "name" => "Clean Out",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "F",
                "name" => "Septic Tank",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "G",
                "name" => "Washer",
            ),
            array(
                "cat_code" => "AA",
                "spec_code" => "H",
                "name" => "Portable Water Supply",
            ),
            array(
                "cat_code" => "AB",
                "spec_code" => "1",
                "name" => "Bahan Insulasi Terhadap Temperatur",
            ),
            array(
                "cat_code" => "AB",
                "spec_code" => "2",
                "name" => "Bahan Insulasi Suara",
            ),
            array(
                "cat_code" => "AC",
                "spec_code" => "1",
                "name" => "Material-Cat-Tembok",
            ),
            array(
                "cat_code" => "AC",
                "spec_code" => "2",
                "name" => "Material-Cat-Kayu/Besi",
            ),
            array(
                "cat_code" => "AC",
                "spec_code" => "3",
                "name" => "Material-Cat-Pelitur/Vernis",
            ),
            array(
                "cat_code" => "AC",
                "spec_code" => "4",
                "name" => "Material-Cat-Flurorescent/Phospor Paint",
            ),
            array(
                "cat_code" => "AC",
                "spec_code" => "5",
                "name" => "Material-Cat-Marka Jalan",
            ),
            array(
                "cat_code" => "AC",
                "spec_code" => "6",
                "name" => "Cat Dasar & Protective Coating",
            ),
            array(
                "cat_code" => "AC",
                "spec_code" => "7",
                "name" => "Cat Epoxy Nitofloor FC 150",
            ),
            array(
                "cat_code" => "AD",
                "spec_code" => "1",
                "name" => "Meja",
            ),
            array(
                "cat_code" => "AD",
                "spec_code" => "2",
                "name" => "Kursi",
            ),
            array(
                "cat_code" => "AD",
                "spec_code" => "3",
                "name" => "Almari",
            ),
            array(
                "cat_code" => "AD",
                "spec_code" => "4",
                "name" => "Kitchen Set",
            ),
            array(
                "cat_code" => "AD",
                "spec_code" => "5",
                "name" => "Tempat Tidur",
            ),
            array(
                "cat_code" => "AD",
                "spec_code" => "6",
                "name" => "Sekat / Partisi",
            ),
            array(
                "cat_code" => "AD",
                "spec_code" => "7",
                "name" => "White Board",
            ),
            array(
                "cat_code" => "AD",
                "spec_code" => "8",
                "name" => "Pintu",
            ),
            array(
                "cat_code" => "AD",
                "spec_code" => "9",
                "name" => "Perlengkapan Mess- barak (piring, gelas,dll)",
            ),
            array(
                "cat_code" => "AD",
                "spec_code" => "1",
                "name" => "Asbes",
            ),
            array(
                "cat_code" => "AD",
                "spec_code" => "1",
                "name" => "Sofa",
            ),
            array(
                "cat_code" => "AD",
                "spec_code" => "1",
                "name" => "Material Atap/Roof",
            ),
            array(
                "cat_code" => "A8",
                "spec_code" => "3",
                "name" => "Gypsum Rangka Besi",
            ),
            array(
                "cat_code" => "AE",
                "spec_code" => "1",
                "name" => "Rumput",
            ),
            array(
                "cat_code" => "AE",
                "spec_code" => "2",
                "name" => "Tanaman Dalam Ruangan",
            ),
            array(
                "cat_code" => "AE",
                "spec_code" => "3",
                "name" => "Tanaman Luar Ruangan",
            ),
            array(
                "cat_code" => "AE",
                "spec_code" => "4",
                "name" => "Tanaman Pohon Pelindung",
            ),
            array(
                "cat_code" => "AE",
                "spec_code" => "5",
                "name" => "Rumput Ijuk",
            ),
            array(
                "cat_code" => "AG",
                "spec_code" => "1",
                "name" => "Zinc Coated Plate / Seng",
            ),
            array(
                "cat_code" => "AG",
                "spec_code" => "2",
                "name" => "Profil Aluminium",
            ),
            array(
                "cat_code" => "AG",
                "spec_code" => "3",
                "name" => "Zincalum",
            ),
            array(
                "cat_code" => "AG",
                "spec_code" => "4",
                "name" => "Galvalum",
            ),
            array(
                "cat_code" => "AG",
                "spec_code" => "5",
                "name" => "Titanium & Titanium Alloy",
            ),
            array(
                "cat_code" => "AG",
                "spec_code" => "6",
                "name" => "Magnesium & Magnesium Alloy",
            ),
            array(
                "cat_code" => "AG",
                "spec_code" => "7",
                "name" => "Tembaga & Paduan Tembaga",
            ),
            array(
                "cat_code" => "AG",
                "spec_code" => "8",
                "name" => "Nikel & Paduan Tembaga",
            ),
            array(
                "cat_code" => "AG",
                "spec_code" => "9",
                "name" => "Cobalt & Paduan Cobalt",
            ),
            array(
                "cat_code" => "AG",
                "spec_code" => "A",
                "name" => "Seng",
            ),
            array(
                "cat_code" => "AG",
                "spec_code" => "B",
                "name" => "Cadmium Dan Paduannya",
            ),
            array(
                "cat_code" => "AG",
                "spec_code" => "C",
                "name" => "Timbal & Tembaga",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "1",
                "name" => "Wire Mesh",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "2",
                "name" => "Expanded Metal Mesh",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "3",
                "name" => "Pagar BRC",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "4",
                "name" => "Bollard",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "5",
                "name" => "Paku",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "6",
                "name" => "Baut/Anchor Bolt/Dynabolt",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "7",
                "name" => "Mur",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "8",
                "name" => "Ring / Washer",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "9",
                "name" => "Pipa Baja",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "A",
                "name" => "Fitting Pipa Baja",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "B",
                "name" => "Tiang PJU",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "C",
                "name" => "Guard-Rail",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "D",
                "name" => "Kawat Duri ( Barbed Wire )",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "E",
                "name" => "Grating",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "F",
                "name" => "Atap Baja",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "G",
                "name" => "Baja Profil ",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "H",
                "name" => "Pelat Baja Hitam ( Hot Rolled Plate )",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "I",
                "name" => "Pelat Baja Putih ( Cold Rolled Plate )",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "J",
                "name" => "Pelat Baja Stainless Steel",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "K",
                "name" => "Steel Sheet Pile",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "L",
                "name" => "Besi As / Assental Shaft",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "M",
                "name" => "Lining Matress",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "N",
                "name" => "Tiang Pancang Baja",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "O",
                "name" => "Girder Baja",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "P",
                "name" => "Besi Siku",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "Q",
                "name" => "Besi UNP",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "R",
                "name" => "Kawat BWG",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "S",
                "name" => "Wire Rope / Sling",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "T",
                "name" => "Treaded Rod/Btg Baja Berulir",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "U",
                "name" => "Kawat Las",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "V",
                "name" => "Pipa Stainless Steel",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "W",
                "name" => "Corrugated hard Polyethylene Pipe (CHP) ",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "X",
                "name" => "Pipa Gorong-gorong (Baja)",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "Y",
                "name" => "Waller Beam",
            ),
            array(
                "cat_code" => "AH",
                "spec_code" => "Z",
                "name" => "Pagar Duri",
            ),
            array(
                "cat_code" => "AI",
                "spec_code" => "1",
                "name" => "Additive Concrete",
            ),
            array(
                "cat_code" => "AI",
                "spec_code" => "2",
                "name" => "Explosive Agent / Handak",
            ),
            array(
                "cat_code" => "AI",
                "spec_code" => "3",
                "name" => "Additive Keramik",
            ),
            array(
                "cat_code" => "AI",
                "spec_code" => "4",
                "name" => "Waterproofing",
            ),
            array(
                "cat_code" => "AI",
                "spec_code" => "5",
                "name" => "Grouting",
            ),
            array(
                "cat_code" => "AI",
                "spec_code" => "6",
                "name" => "Floor Hardener",
            ),
            array(
                "cat_code" => "AI",
                "spec_code" => "7",
                "name" => "Concrete Repair (Perbaikan Beton)",
            ),
            array(
                "cat_code" => "AI",
                "spec_code" => "8",
                "name" => "Bonding Agent (Penyambung Beton)-Kelompok Pekerjaan Beton",
            ),
            array(
                "cat_code" => "AI",
                "spec_code" => "9",
                "name" => "Liquid Compound, Curing-Compound (Penghambat Evaporasi Air Dari Beton)",
            ),
            array(
                "cat_code" => "AI",
                "spec_code" => "1",
                "name" => "Chemical Resistant Substance",
            ),
            array(
                "cat_code" => "AI",
                "spec_code" => "A",
                "name" => "Chemical Resistant Substance",
            ),
            array(
                "cat_code" => "AJ",
                "spec_code" => "1",
                "name" => "Pipa PVC",
            ),
            array(
                "cat_code" => "AJ",
                "spec_code" => "3",
                "name" => "Tanki Air PVC/Plastik Lainnya",
            ),
            array(
                "cat_code" => "AJ",
                "spec_code" => "4",
                "name" => "PE Ducting",
            ),
            array(
                "cat_code" => "AJ",
                "spec_code" => "5",
                "name" => "PE Anchore Sistem",
            ),
            array(
                "cat_code" => "AJ",
                "spec_code" => "6",
                "name" => "Lembar",
            ),
            array(
                "cat_code" => "AJ",
                "spec_code" => "7",
                "name" => "Polycarbonat",
            ),
            array(
                "cat_code" => "AJ",
                "spec_code" => "8",
                "name" => "Fibreglass / Fibre Reinforced Plastic (FRP)",
            ),
            array(
                "cat_code" => "AJ",
                "spec_code" => "9",
                "name" => "Geotextile",
            ),
            array(
                "cat_code" => "AJ",
                "spec_code" => "A",
                "name" => "HDPE",
            ),
            array(
                "cat_code" => "AJ",
                "spec_code" => "B",
                "name" => "Flexibel Pipe / Hose",
            ),
            array(
                "cat_code" => "AJ",
                "spec_code" => "C",
                "name" => "Plastic Cone",
            ),
            array(
                "cat_code" => "AJ",
                "spec_code" => "D",
                "name" => "Plastik Cor",
            ),
            array(
                "cat_code" => "AJ",
                "spec_code" => "E",
                "name" => "Plastic Sheet",
            ),
            array(
                "cat_code" => "AJ",
                "spec_code" => "F",
                "name" => "Vertical Drain (PVD Alidrain HB 63)",
            ),
            array(
                "cat_code" => "AK",
                "spec_code" => "1",
                "name" => "Fender",
            ),
            array(
                "cat_code" => "AK",
                "spec_code" => "2",
                "name" => "Conveyor Belt",
            ),
            array(
                "cat_code" => "AK",
                "spec_code" => "3",
                "name" => "Rubber Track",
            ),
            array(
                "cat_code" => "AK",
                "spec_code" => "4",
                "name" => "Hydraulik Hose",
            ),
            array(
                "cat_code" => "AK",
                "spec_code" => "5",
                "name" => "Seismik Isolator For Building",
            ),
            array(
                "cat_code" => "AK",
                "spec_code" => "6",
                "name" => "Water Stop Karet",
            ),
            array(
                "cat_code" => "AK",
                "spec_code" => "7",
                "name" => "Bearing Pad",
            ),
            array(
                "cat_code" => "AK",
                "spec_code" => "8",
                "name" => "Karet Expansion Joint",
            ),
            array(
                "cat_code" => "AK",
                "spec_code" => "9",
                "name" => "Rubber Mounting",
            ),
            array(
                "cat_code" => "AK",
                "spec_code" => "A",
                "name" => "House Mat",
            ),
            array(
                "cat_code" => "AK",
                "spec_code" => "B",
                "name" => "Dock Bumper",
            ),
            array(
                "cat_code" => "AK",
                "spec_code" => "C",
                "name" => "Bendung Karet",
            ),
            array(
                "cat_code" => "AK",
                "spec_code" => "D",
                "name" => "Ban / Tire",
            ),
            array(
                "cat_code" => "AL",
                "spec_code" => "1",
                "name" => "Bitumen-Aspal Ex Minyak Bumi",
            ),
            array(
                "cat_code" => "AM",
                "spec_code" => "1",
                "name" => "Material Mekanikal - Fitting",
            ),
            array(
                "cat_code" => "AM",
                "spec_code" => "2",
                "name" => "Material Mekanikal - Flanges",
            ),
            array(
                "cat_code" => "AM",
                "spec_code" => "3",
                "name" => "Material Mekanikal - Blind Flanges",
            ),
            array(
                "cat_code" => "AM",
                "spec_code" => "4",
                "name" => "Material - Mekanikal  & Elektrikal-Valve/Katup",
            ),
            array(
                "cat_code" => "AM",
                "spec_code" => "5",
                "name" => "Mekanikal - Gauge",
            ),
            array(
                "cat_code" => "AM",
                "spec_code" => "6",
                "name" => "Package Material",
            ),
            array(
                "cat_code" => "AM",
                "spec_code" => "7",
                "name" => "Mesin Atau Alat Penimbang, Timbangan",
            ),
            array(
                "cat_code" => "AN",
                "spec_code" => "1",
                "name" => "Avtur",
            ),
            array(
                "cat_code" => "AN",
                "spec_code" => "2",
                "name" => "BBM Premium",
            ),
            array(
                "cat_code" => "AN",
                "spec_code" => "3",
                "name" => "BBM Solar",
            ),
            array(
                "cat_code" => "AN",
                "spec_code" => "4",
                "name" => "BBM Minyak Bakar",
            ),
            array(
                "cat_code" => "AN",
                "spec_code" => "5",
                "name" => "BBM Minyak Tanah",
            ),
            array(
                "cat_code" => "AN",
                "spec_code" => "6",
                "name" => "BBM Minyak Diesel",
            ),
            array(
                "cat_code" => "AN",
                "spec_code" => "7",
                "name" => "BBM Pertamina DEX",
            ),
            array(
                "cat_code" => "AN",
                "spec_code" => "8",
                "name" => "Minyak Pelumas",
            ),
            array(
                "cat_code" => "AN",
                "spec_code" => "9",
                "name" => "Grease",
            ),
            array(
                "cat_code" => "AN",
                "spec_code" => "A",
                "name" => "Aditive Pelumas",
            ),
            array(
                "cat_code" => "AN",
                "spec_code" => "B",
                "name" => "Minyak Bio Solar",
            ),
            array(
                "cat_code" => "AN",
                "spec_code" => "C",
                "name" => "Minyak Nabati",
            ),
            array(
                "cat_code" => "AO",
                "spec_code" => "1",
                "name" => "Turbin Uap (Steam Turbine)",
            ),
            array(
                "cat_code" => "AO",
                "spec_code" => "2",
                "name" => "Turbin Hidrolik, Turbin/Kincir Air, Dan Regulatornya",
            ),
            array(
                "cat_code" => "AO",
                "spec_code" => "3",
                "name" => "Turbin Gas (Gas Turbine)",
            ),
            array(
                "cat_code" => "AO",
                "spec_code" => "4",
                "name" => "Pompa Untuk Pengisian Bahan Bakar Atau Pelumas",
            ),
            array(
                "cat_code" => "AO",
                "spec_code" => "5",
                "name" => "Pompa Positive-Displacement Baik Dari Jenis Reciprocating-Pump Maupun Rotary-Pump",
            ),
            array(
                "cat_code" => "AO",
                "spec_code" => "6",
                "name" => "Pompa Sentrifugal",
            ),
            array(
                "cat_code" => "AO",
                "spec_code" => "7",
                "name" => "Pompa Udara / Pompa Vakum, Kompresor (Compressors),  Dan Kipas Angin (Fan)",
            ),
            array(
                "cat_code" => "AO",
                "spec_code" => "8",
                "name" => "Pompa Submersible",
            ),
            array(
                "cat_code" => "AP",
                "spec_code" => "1",
                "name" => "Steam Boiler Untuk Pembangkit Listrik Dan Industri.",
            ),
            array(
                "cat_code" => "AP",
                "spec_code" => "2",
                "name" => "Instalasi Pembantu (Auxiliary Plant) Untuk Digunakan Dengan  Steam Boilers .",
            ),
            array(
                "cat_code" => "AP",
                "spec_code" => "3",
                "name" => "Unit Penukar Panas (Heat Exchanger):",
            ),
            array(
                "cat_code" => "AP",
                "spec_code" => "4",
                "name" => "Tungku Pembakaran (Furnace Burners).",
            ),
            array(
                "cat_code" => "AQ",
                "spec_code" => "1",
                "name" => "Window",
            ),
            array(
                "cat_code" => "AQ",
                "spec_code" => "2",
                "name" => "Split( AC)",
            ),
            array(
                "cat_code" => "AQ",
                "spec_code" => "3",
                "name" => "Portable (AC)",
            ),
            array(
                "cat_code" => "AQ",
                "spec_code" => "4",
                "name" => "Cassette (AC)",
            ),
            array(
                "cat_code" => "AQ",
                "spec_code" => "5",
                "name" => "AC Kendaraan",
            ),
            array(
                "cat_code" => "AQ",
                "spec_code" => "6",
                "name" => "Fire Alarm System",
            ),
            array(
                "cat_code" => "AQ",
                "spec_code" => "7",
                "name" => "Gas Detector",
            ),
            array(
                "cat_code" => "AQ",
                "spec_code" => "8",
                "name" => "Fire Supression System",
            ),
            array(
                "cat_code" => "AQ",
                "spec_code" => "9",
                "name" => "Plant Services",
            ),
            array(
                "cat_code" => "AQ",
                "spec_code" => "1",
                "name" => "AC Ruangan",
            ),
            array(
                "cat_code" => "AR",
                "spec_code" => "1",
                "name" => "Kabel, Termasuk Kabel Koaksial ), Kawat (Termasuk Dienamel Atau Dianodisasi) Diisolasi, Wire, Dan Konduktor Listrik Diisolasi Lainnya,  Kabel Serat Optik",
            ),
            array(
                "cat_code" => "AR",
                "spec_code" => "2",
                "name" => "Bushduct",
            ),
            array(
                "cat_code" => "AR",
                "spec_code" => "3",
                "name" => "Accessories Electrical / Bulk Material Seperti Sepatu Kabel , Connector , Cable Gland & Fitting Elektrik",
            ),
            array(
                "cat_code" => "AR",
                "spec_code" => "4",
                "name" => "Raceway",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "1",
                "name" => "Motor Listrik",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "2",
                "name" => "Generator / Perangkat Pembangkit Tenaga Listrik Dan Konverter Berputar (Rotary Converters)",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "3",
                "name" => "Transformator/Trafo Listrik, Konverter Statis  (Rectifier) Dan Induktor.",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "4",
                "name" => "Magnet Permanen Dan Barang Untuk Dijadikan Magnet Permanen Setelah Diberi Gaya Magnet; Chuck, Klem Dan Peralatan Pemegang Sejenis Yang Bekerja Secara Elektro Magnetis Atau Bermagnet Permanen;",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "5",
                "name" => "Sel/Baterai Primer, Akumulator Listrik/Accu",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "6",
                "name" => "Perangkat Telepon, Termasuk Telepon Seluler Atau Nirkabel (Wireless); Alat Lainnya Untuk Mengirimkan Atau Menerima Suara, Gambar, Atau Data",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "7",
                "name" => "Kapasitor Listrik Tetap, Variabel Atau Dapat Disesuaikan (Pre-Set), Capacitor Bank",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "8",
                "name" => "Resistor Listrik (Termasuk Rheostat Dan Potensiometer)",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "9",
                "name" => "Aparatus Listrik Untuk Switching Atau Proteksi Sirkit Listrik, Atau Untuk Membuat Hubungan Pada Sirkit Listrik (Sakelar, Sekering/Fuse, Penangkal Petir, Pembatas Voltase, Surge Arrester, Stop Kontak Dan Konektor Lainnya, Junction Boxes)",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "A",
                "name" => "Papan, Panel, Konsol, Meja/Desk, Atau Kabinet, Dilengkapi Komponen Untuk Pengontrol Listrik Atau Pendistribusi Listrik",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "B",
                "name" => "Lampu Pijar, Lampu Tabung, Termasuk Lampu Ultraviolet Atau Infra-Merah; Lampu Busur.",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "C",
                "name" => "Isolator Listrik Dari Berbagai Bahan.",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "D",
                "name" => "Mesin Pengolah Data Otomatis (Automatic Data Processing Machines) Dan Unitnya;",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "E",
                "name" => "Hidrometer Dan Instrumen Sejenis, Termometer, Pirometer, Barometer, Higrometer Dan Kombinasi Dari Instrumen Tersebut.",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "F",
                "name" => "Instrumen Untuk Mengukur Flow/Debit, Tinggi Permukaan/Level, Tekanan  Cairan Atau Gas (Flow Meter, Level Gauge, Manometer)",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "G",
                "name" => "Instrumen Untuk Analisa Sifat Fisika/Kimia (Polarimeter, Refraktometer, Spektrometer); Instrumen Pengukur Viskositas, Porositas, Tegangan Permukaan; Instrument Pengukur Intensitas Panas, Suara,  Cahaya,  Kromatograf",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "H",
                "name" => "Alat Ukur Pasokan Atau Produksi Gas, Cairan Atau  Listrik Termasuk Kalibrasinya.",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "I",
                "name" => "Penghitung Putaran/Rotasi, Penghitung Produksi, Taksimeter, Pengukur Jarak/Odometer; Indikator Kecepatan Dan Tachometer",
            ),
            array(
                "cat_code" => "AS",
                "spec_code" => "J",
                "name" => "Instrumen Pengatur Atau Pengontrol Otomatis (Automatic Regulator/Controller), Termostat, Hidrolik Atau Pneumatik",
            ),
            array(
                "cat_code" => "AT",
                "spec_code" => "1",
                "name" => "Lathe Machine / Mesin Bubut",
            ),
            array(
                "cat_code" => "AT",
                "spec_code" => "2",
                "name" => "Mesin Frais / Milling Machine",
            ),
            array(
                "cat_code" => "AT",
                "spec_code" => "3",
                "name" => "Mesin Sekrap",
            ),
            array(
                "cat_code" => "AT",
                "spec_code" => "4",
                "name" => "Mesin Las / Solder / Welding Machine",
            ),
            array(
                "cat_code" => "AT",
                "spec_code" => "5",
                "name" => "Mesin Gerinda / Grinding Machine",
            ),
            array(
                "cat_code" => "AT",
                "spec_code" => "6",
                "name" => "Mesin Bor / Drilling Machine",
            ),
            array(
                "cat_code" => "AT",
                "spec_code" => "7",
                "name" => "Hammer",
            ),
            array(
                "cat_code" => "AT",
                "spec_code" => "8",
                "name" => "Hand Tools",
            ),
            array(
                "cat_code" => "AT",
                "spec_code" => "9",
                "name" => "Las Asetilen + Oksigen",
            ),
            array(
                "cat_code" => "AU",
                "spec_code" => "1",
                "name" => "Material Bantu Excavation",
            ),
            array(
                "cat_code" => "AU",
                "spec_code" => "2",
                "name" => "Material Bantu Pengecoran",
            ),
            array(
                "cat_code" => "AU",
                "spec_code" => "3",
                "name" => "Perlengkapan safety",
            ),
            array(
                "cat_code" => "AU",
                "spec_code" => "4",
                "name" => "Material Hardener Floor",
            ),
            array(
                "cat_code" => "AU",
                "spec_code" => "5",
                "name" => "Material Consummable utk pengelasan/pembesian",
            ),
            array(
                "cat_code" => "AU",
                "spec_code" => "6",
                "name" => "Material Painting Marka",
            ),
            array(
                "cat_code" => "AU",
                "spec_code" => "7",
                "name" => "Add. Material & Tools for Pouring Ashpalt/Jalan",
            ),
        );

        $data_insert = [];
        foreach ($specification_helper as $v)
        {
            $data = [
                'code' => $v['spec_code'],
                'name' => $v['name'],
                'category_id' => $category_pk[$v['cat_code']],
                'created_by' => 1
            ];
            $data_insert[] = $data;
        }
        //var_dump($data_insert);
        $this->db->insert_batch('specification', $data_insert);

        //echo '<pre>';
        //print_r($this->db->queries);
        //echo '</pre>';
        $this->db->trans_complete();

    }

    public function down()
    {

    }
}
