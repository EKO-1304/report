<?php
namespace Modules\Layout\Models;

use CodeIgniter\Model;

class ModelLayout extends Model
{
    //protected $table = 'users';
    //protected $useTimestamps = 'true';
	protected $db;

    public function __construct(){

		$this->db = \Config\Database::connect();

	}

    public function get_group_menu(){
		return $this->db
		->table('menu_group')
		->select('manage,nama_group,menu_group.id')
		->join('menu','menu.id_group=menu_group.id','left')
		->where('menu_group.deleted_at', null)
		->where('menu_group.status', 1)
		->groupBy('menu.id_group')
		->orderBy('menu_group.no_urut', 'asc')
		->get()
		->getResultArray();
    }

}
