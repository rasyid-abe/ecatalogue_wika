<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_insert_master_data_size_111 extends CI_Migration {

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up()
    {
        $size_helper = array(
          array(
          	"cat_code" => "A9",
          	"spec_code" => "1",
          	"size_code" => "001",
          	"name" => "Granite Tile 60 x 60 cm",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "2",
          	"size_code" => "002",
          	"name" => "Marble Tile 60 x 60 cm",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "001",
          	"name" => "Ceramic Homogenous",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "002",
          	"name" => "Ceramic Mosaic (Glazed Tile)",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "003",
          	"name" => "Ceramic Mosaic 25 x 25",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "004",
          	"name" => "Skirting Ceramic 10 x 40 cm",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "005",
          	"name" => "Keramik Anti Slip",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "006",
          	"name" => "Keramik Dinding",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "007",
          	"name" => "Keramik Lantai",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "008",
          	"name" => "Anti-statik Vinyl floor tile",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "009",
          	"name" => "Concrete walkway, 150mm thick, with mesh",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "010",
          	"name" => "Concrete walkway, 250mm thick, with mesh",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "011",
          	"name" => "Acoustic Tile",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "012",
          	"name" => "Anti-statik Vinyl floor tile",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "013",
          	"name" => "Carpet tile",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "014",
          	"name" => "Ceramic 20 x 20 cm",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "015",
          	"name" => "Ceramic 20 x 40 cm",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "016",
          	"name" => "Ceramic 40 x 40 cm",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "017",
          	"name" => "Ceramic Mosaic",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "018",
          	"name" => "Ceramic Mosaic (Glazed Tile)",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "019",
          	"name" => "Ceramic Mosaic 25 x 25",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "020",
          	"name" => "Ceramic Mosaic 25 x 25 for skirting",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "021",
          	"name" => "Ceramic Tile for Floor",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "022",
          	"name" => "Ceramic Tile for Skirt",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "023",
          	"name" => "Ceramic Tile for Wall",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "024",
          	"name" => "Floor (Slippery & scratch resistant coated floor)",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "025",
          	"name" => "Genteng Keramik",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "026",
          	"name" => "Keramik 20x30",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "027",
          	"name" => "Keramik 30x30",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "028",
          	"name" => "Keramik Dinding",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "029",
          	"name" => "Keramik Lantai",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "030",
          	"name" => "Keramik Terracotta",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "031",
          	"name" => "Mob Demob Sheep Foot",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "032",
          	"name" => "Raised floor",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "033",
          	"name" => "Soft Cove Base (T=10cm)",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "034",
          	"name" => "Tile Ceramic",
          ),
          array(
          	"cat_code" => "A9",
          	"spec_code" => "4",
          	"size_code" => "035",
          	"name" => "Wall Ceramic",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "001",
          	"name" => "Cat Tembok (Untuk Jalan)",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "002",
          	"name" => "Vermitex TH (Fire proofing paint)",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "003",
          	"name" => "Vinyl Emulsion Paint (External)",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "004",
          	"name" => "Vinyl Emulsion Paint (Internal)",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "005",
          	"name" => "Acid Paint",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "006",
          	"name" => "Acrylic paint",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "007",
          	"name" => "Amplas",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "008",
          	"name" => "Cat Marka",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "009",
          	"name" => "Cat Tembok",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "010",
          	"name" => "Cat Tembok (Untuk Jalan)",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "011",
          	"name" => "Chemical Resistant Paint",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "012",
          	"name" => "Dust paint",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "013",
          	"name" => "Emulsiont Paint",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "014",
          	"name" => "Epoxy Paint",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "015",
          	"name" => "Exterior Painting for Container Office",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "016",
          	"name" => "Interior Painting for Container Office",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "017",
          	"name" => "Paint",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "018",
          	"name" => "Pelamir",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "019",
          	"name" => "Vinyl Emulsion Paint",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "020",
          	"name" => "Vinyl Emulsion Paint (External)",
          ),
          array(
          	"cat_code" => "AC",
          	"spec_code" => "1",
          	"size_code" => "021",
          	"name" => "Vinyl Emulsion Paint (Internal)",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "001",
          	"name" => "Wire Mesh Dia. 6@150",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "002",
          	"name" => "Wire Mesh h = 1.8 m Ø 2 mm (2\" x 2\")",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "003",
          	"name" => "Wire Mesh Ø 8 mm",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "004",
          	"name" => "Alkon 3 inch",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "005",
          	"name" => "Barbed Wire Heavy Galvanized dia=2.0~2.6 mm",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "006",
          	"name" => "Chainlink Included frame, bolt & nut",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "007",
          	"name" => "Chicken mesh + install",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "008",
          	"name" => "Paranet - Jala",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "009",
          	"name" => "PDPK Material Bantu",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "010",
          	"name" => "PDPK Upah",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "011",
          	"name" => "Welded wire fabric D6 x 150 x 150",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "012",
          	"name" => "Welded wire fabric D8 x 150 x 150",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "013",
          	"name" => "Wire Mesh",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "014",
          	"name" => "Wire Mesh dia 1.3 mm, 3/4 x 3/4 inch",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "015",
          	"name" => "Wire Mesh dia 10 mm (M10-150x150), 5,4x2,1 m/lbr",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "016",
          	"name" => "Wire Mesh dia 4 mm, 10 x 10 cm",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "017",
          	"name" => "Wire Mesh dia 6 mm",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "018",
          	"name" => "Wire Mesh dia 6 mm (M6-150x150), 5,4x2,1 m/lbr",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "019",
          	"name" => "Wire Mesh dia 8 mm",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "020",
          	"name" => "Wire Mesh dia 8 mm (M8-150x150), 5,4x2,1 m/lbr",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "021",
          	"name" => "Wire Mesh dia. 1.3 mm, 3/4 x 3/4 inch",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "022",
          	"name" => "Wire Mesh dia. 10 mm (M10-150x150), 5,4x2,1 m/lbr",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "023",
          	"name" => "Wire Mesh Dia. 3@150",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "024",
          	"name" => "Wire Mesh dia. 4 mm, 10 x 10 cm",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "025",
          	"name" => "Wire Mesh dia. 6 mm",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "026",
          	"name" => "Wire Mesh Dia. 6@150",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "027",
          	"name" => "Wire Mesh dia. 8 mm",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "028",
          	"name" => "Wire Mesh h = 1.8 m dia. 2 mm (2inc x 2inc)",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "029",
          	"name" => "Wire Mesh M 8",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "030",
          	"name" => "Wiremesh",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "031",
          	"name" => "Wiremesh M-6",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "032",
          	"name" => "Wiremesh M7",
          ),
          array(
          	"cat_code" => "AH",
          	"spec_code" => "1",
          	"size_code" => "033",
          	"name" => "Wiremesh M8",
          ),
          );

          $this->db->trans_start();

          $data_insert = [];
          $spec_code = [];
          foreach ($size_helper as $v)
          {
              $index_spec_code = $v['cat_code'] . '_' . $v['spec_code'];
              if ( ! array_key_exists($index_spec_code, $spec_code) )
              {
                  $this->db->select("a.id")
                  ->from('specification as a')
                  ->join('category as b','a.category_id = b.id')
                  ->where(['b.code' => $v['cat_code'], 'a.code' => $v['spec_code']]);
                  $spec_id = $this->db->get()->row()->id;
                  $spec_code[$index_spec_code] = $spec_id;
              }

              $data_insert[] = [
                  'code' => $v['size_code'],
                  'name' => $v['name'],
                  'specification_id' => $spec_id,
                  'default_weight' => 1,
                  'created_by' => 1
              ];
          }

          $this->db->insert_batch('size', $data_insert);
          $this->db->trans_complete();
          //echo '<pre>';
          //print_r($this->db->queries);
          //echo '</pre>';
    }

    public function down()
    {

    }
}
