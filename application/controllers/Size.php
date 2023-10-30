<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Size extends Admin_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('size_model');
        $this->load->model('specification_model');
    }

    public function index()
    {
        $this->load->helper('url');
        if($this->data['is_can_read']){
            $this->data['judul'] = 'Spesifikasi';
            $this->data['content']  = 'admin/size/list_v';
        }else{
            redirect('restrict');
        }
        $this->load->view('admin/layouts/page',$this->data);
    }

  public function create()
  {
    $this->form_validation->set_rules('name',"Nama Harus Diisi", 'trim|required');

        if ($this->form_validation->run() === TRUE)
        {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'specification_id' => $this->input->post('specification_id'),
                'default_weight' => $this->input->post('default_weight'),
                'code' => $this->input->post('code'),
                'created_by' => $this->data['users']->id,

            );
            if ($this->size_model->insert($data))
            {
                $this->session->set_flashdata('message', "Ukuran Baru Berhasil Disimpan");
                redirect("size");
            }
            else
            {
                $this->session->set_flashdata('message_error',"Ukuran Baru Gagal Disimpan");
                redirect("size");
            }
        }else{
            //$this->data['specification'] = $this->specification_model->getAllById();
            $where['specification.is_deleted'] = 0;
            $this->data['specification'] = $this->specification_model->getSpecWithCat($where);
            $this->data['content'] = 'admin/size/create_v';
            $this->load->view('admin/layouts/page',$this->data);
        }
  }

  public function edit($id)
  {
    $this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');

    if ($this->form_validation->run() === TRUE)
    {
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'specification_id' => $this->input->post('specification_id'),
            'default_weight' => $this->input->post('default_weight'),
            'code' => $this->input->post('code'),
            'updated_by' => $this->data['users']->id,
        );
        $update = $this->size_model->update($data,array("size.id"=>$id));
        if ($update)
        {
            $this->session->set_flashdata('message', "Ukuran Berhasil Diubah");
            redirect("size","refresh");
        }else{
            $this->session->set_flashdata('message_error', "Ukuran Gagal Diubah");
            redirect("size","refresh");
        }
    }
    else
    {
        if(!empty($_POST)){
            $id = $this->input->post('id');
            $this->session->set_flashdata('message_error',validation_errors());
            return redirect("size/edit/".$id);
        }else{
            //$this->data['specification'] = $this->specification_model->getAllById();
            $where['specification.is_deleted'] = 0;
            $this->data['specification'] = $this->specification_model->getSpecWithCat($where);
            $this->data['id']= $this->uri->segment(3);
            $size = $this->size_model->getOneBy(array("size.id"=>$this->data['id']));
            $this->data['name'] =   (!empty($size))?$size->name:"";
            $this->data['description'] =   (!empty($size))?$size->description:"";
            $this->data['specification_id'] =   (!empty($size))?$size->specification_id:"";
            $this->data['default_weight'] =   (!empty($size))?$size->default_weight:"";
            $this->data['code'] =   (!empty($size))?$size->code:"";

            $this->data['content'] = 'admin/size/edit_v';
            $this->load->view('admin/layouts/page',$this->data);
        }
    }
  }

    public function dataList()
    {
        $columns = array(
            0 =>'size.id',
            1 =>'size.name',
            2=> 'specification.name',
            3=> 'size.default_weight',
        );


        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = array();
        $where['size.is_deleted !='] = 2;
        $limit = 0;
        $start = 0;
        $totalData = $this->size_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);


        if(!empty($this->input->post('search')['value'])){
            $search_value = $this->input->post('search')['value'];
            $search = array(
                "size.name"=>$search_value,
                "size.description"=>$search_value,
                "specification.name"=>$search_value,
            );
            $totalFiltered = $this->size_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);
        }else{
            $totalFiltered = $totalData;
        }

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $datas = $this->size_model->getAllBy($limit,$start,$search,$order,$dir,$where);

        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {

                $edit_url = "";
                $delete_url = "";
                $delete_permanent ="";

                if($this->data['is_can_edit'] && $data->is_deleted == 0){
                    $edit_url =  "<a href='".base_url()."size/edit/".$data->id."' data-id='".$data->id."' style='color: white;'><div class='btn btn-sm btn-primary btn-blue btn-editview '>Ubah</div></a>";
                }
                if($this->data['is_can_delete']){
                    if($data->is_deleted == 0){
                        $delete_url = "<a href='#'
                            data-id='".$data->id."' data-isdeleted='".$data->is_deleted."' class='btn btn-sm btn-danger white delete' url='".base_url()."size/destroy/".$data->id."/".$data->is_deleted."' >Non Aktifkan
                            </a>";
                    }else{
                        $delete_url = "<a href='#'
                            data-id='".$data->id."' data-isdeleted='".$data->is_deleted."' class='btn btn-sm btn-success white delete'
                             url='".base_url()."size/destroy/".$data->id."/".$data->is_deleted."'>Aktifkan
                            </a>";
                        $delete_permanent = "<a  href='#' url='".base_url()."size/destroy_permanent/".$data->id."' class='btn btn-sm btn-danger white delete'><i class='fa fa-trash-o'></i> Hapus</a>";
                    }
                }
                $nestedData['id'] = $start+$key+1;
                $nestedData['name'] = $data->name;
                $nestedData['specification_name'] = $data->specification_name;
                $nestedData['default_weight'] = $data->default_weight;
                $nestedData['description'] = substr(strip_tags($data->description),0,50);
                if($data->is_deleted==0){
                    $nestedData['status']       = "Active";
                }else{
                    $nestedData['status']       = "Inactive";
                }
                $nestedData['action']           = $edit_url." ".$delete_url." ".$delete_permanent;
                $new_data[] = $nestedData;
            }
        }

        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $new_data
                    );

        echo json_encode($json_data);
    }
    public function destroy(){
        $response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();

        $id =$this->uri->segment(3);
        $is_deleted = $this->uri->segment(4);
        if(!empty($id)){
            $data = array(
                'is_deleted' => ($is_deleted == 1)?0:1,
                'updated_by' => $this->data['users']->id,
            );
            $update = $this->size_model->update($data,array("id"=>$id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        }else{
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }

    public function destroy_permanent(){
        $response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();

        $id =$this->uri->segment(3);
        $is_deleted = $this->uri->segment(4);
        if(!empty($id)){
            $data = array(
                'is_deleted'    => 2,
                'deleted_by'    => $this->data['users']->id,
                'deleted_time'  => $this->data['now_datetime']
            );
            $update = $this->size_model->update($data,array("id"=>$id));

            $response_data['data'] = $data;
            $response_data['status'] = true;
        }else{
            $response_data['msg'] = "ID Harus Diisi";
        }

        echo json_encode($response_data);
    }

    public function exportToExcel()
    {
        $this->load->model('Category_new_model');
        $this->load->model('Category_model');
        $this->load->model('Specification_model');
        $this->load->model('Size_model');
        $where = ['is_deleted' => 0];
        $categoryNew = $this->Category_new_model->getAllById($where);
        $category = [];
        $_catTemp = $this->Category_model->getAllById($where);
        if ($_catTemp !== FALSE)
        {
            foreach ($_catTemp as $key => $value)
            {
                $category[$value->category_new_id][] = $value;
            }
        }

        $specification = [];
        $_specTemp = $this->Specification_model->getAllById($where);
        if ($_specTemp !== FALSE)
        {
            foreach ($_specTemp as $key => $value)
            {
                $specification[$value->category_id][] = $value;
            }
        }

        $size = [];
        $_sizeTemp = $this->Size_model->getAllById();
        if ($_sizeTemp !== FALSE)
        {
            foreach ($_sizeTemp as $key => $value)
            {
                $size[$value->specification_id][] = $value;
            }
        }

        $data = [
            'categoryNew' => $categoryNew,
            'category' => $category,
            'specification' => $specification,
            'size' => $size,
        ];

        $this->load->view('admin/size/export_to_excel_v', $data);
    }

    /*
    function insert_cek()
    {
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
            // $this->db->truncate($v);
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
        echo '<pre>';
        print_r($this->db->queries);
        echo '</pre>';
        $this->db->trans_complete();
    }
    */
}
