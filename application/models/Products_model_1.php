<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Products_model extends CI_Model 
{
	protected $table = 'products';
	
    public function __construct() {
        parent::__construct();
    }

	public function get_total2($search=NULL)
	{
		$this->db->select('id');	
		if(!empty($search))
		{
			if(isset($search['text']))
			{
				$this->db->like('Name', $search['text']);
				$this->db->or_like('RSKnummer0', $search['text']);
				$this->db->or_like('RSKnummer', $search['text']);
				unset($search['text']);
			}
			$this->db->where($search);
		}
		$query = $this->db->get($this->table);
		$num = $query->num_rows();	
		return $num;
	}
	
	public function get_total($search=NULL){
		
		if(isset($search['Manufacturer']))
			$where = 'and Manufacturer='.$search['Manufacturer'];
		else
			$where = '';
		
		if(empty($search))
		{
	        $sql = 'SELECT id FROM '.$this->table;
			$query = $this->db->query($sql);
		}	
		else if(isset($search['category1']))
		{
			if(isset($search['text']))
			{			
				$sql = "SELECT id From ".$this->table." WHERE category1=? and (Name LIKE '%".$search['text']."%' ESCAPE '!' OR RSKnummer0 LIKE '%".$search['text']."%' ESCAPE '!' OR RSKnummer LIKE '%".$search['text']."%' ESCAPE '!') ".$where;			
				$query = $this->db->query($sql,array($search['category1']));
			}
			else
			{			
				$sql = 'SELECT id From '.$this->table.' WHERE category1=? '.$where;
				$query = $this->db->query($sql,array($search['category1']));
			}
		}
		else if(isset($search['category2']))
		{
			if(isset($search['text']))
			{			
				$sql = "SELECT id From ".$this->table." WHERE category2=? and (Name LIKE '%".$search['text']."%' ESCAPE '!' OR RSKnummer0 LIKE '%".$search['text']."%' ESCAPE '!' OR RSKnummer LIKE '%".$search['text']."%' ESCAPE '!') ".$where;
				$query = $this->db->query($sql,array($search['category2']));
			}
			else
			{			
				$sql = 'SELECT id From '.$this->table.' WHERE '.$this->table.'.category2=? '.$where;
				$query = $this->db->query($sql,array($search['category2']));
			}
		}
		else if(isset($search['category3']))
		{
			if(isset($search['text']))
			{			
				$sql = "SELECT id From ".$this->table." WHERE category3=? and (Name LIKE '%".$search['text']."%' ESCAPE '!' OR RSKnummer0 LIKE '%".$search['text']."%' ESCAPE '!' OR RSKnummer LIKE '%".$search['text']."%' ESCAPE '!') ".$where;
				$query = $this->db->query($sql,array($search['category3']));
			}
			else
			{			
				$sql = 'SELECT id From '.$this->table.' WHERE '.$this->table.'.category3=? '.$where;
				$query = $this->db->query($sql,array($search['category3']));
			}
		}
		else if(isset($search['text']))
		{
			$sql = "SELECT id From ".$this->table." WHERE (Name LIKE '%".$search['text']."%' ESCAPE '!' OR RSKnummer0 LIKE '%".$search['text']."%' ESCAPE '!' OR RSKnummer LIKE '%".$search['text']."%' ESCAPE '!') ".$where;
			$query = $this->db->query($sql);
		}
		else if(isset($search['Manufacturer']))
		{
			$sql = "SELECT id From ".$this->table." WHERE Manufacturer=".$search['Manufacturer'];
			$query = $this->db->query($sql);
		}
		return $query->num_rows();
    }
	
	public function get($id){
        $sql = 'SELECT categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName, '.$this->table.'. * From '.$this->table.' INNER JOIN categories ON categories.id = '.$this->table.'.category1 INNER JOIN manufacturer ON manufacturer.id = '.$this->table.'.Manufacturer WHERE '.$this->table.'.id=? ORDER BY id DESC LIMIT 0 , 1';
		$query = $this->db->query($sql,$id);
		return $query->row();
    }
	
	public function get_products($search=NULL,$start=0)
	{
		
		if(isset($search['Manufacturer']))
			$where = 'and '.$this->table.'.Manufacturer='.$search['Manufacturer'];
		else
			$where = '';
		
		if(empty($search))
		{
	        $sql = 'SELECT categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName, '.$this->table.'. * From '.$this->table.' INNER JOIN categories ON categories.id = '.$this->table.'.category1 INNER JOIN manufacturer ON manufacturer.id = '.$this->table.'.Manufacturer ORDER BY '.$this->table.'.id DESC LIMIT ? , 99';
			$query = $this->db->query($sql,$start);
		}	
		else if(isset($search['category1']))
		{
			if(isset($search['text']))
			{			
				$sql = "SELECT categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName, ".$this->table.". * From ".$this->table." INNER JOIN categories ON categories.id = ".$this->table.".category1 INNER JOIN manufacturer ON manufacturer.id = ".$this->table.".Manufacturer WHERE ".$this->table.".category1=? and (".$this->table.".Name LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer0 LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer LIKE '%".$search['text']."%' ESCAPE '!') ".$where." ORDER BY ".$this->table.".id DESC LIMIT ? , 99";
				$query = $this->db->query($sql,array($search['category1'], $start));
			}
			else
			{			
				$sql = 'SELECT categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName, '.$this->table.'. * From '.$this->table.' INNER JOIN categories ON categories.id = '.$this->table.'.category1 INNER JOIN manufacturer ON manufacturer.id = '.$this->table.'.Manufacturer WHERE '.$this->table.'.category1=? '.$where.' ORDER BY '.$this->table.'.id DESC LIMIT ? , 99';
				$query = $this->db->query($sql,array($search['category1'], $start));
			}
		}
		else if(isset($search['category2']))
		{
			if(isset($search['text']))
			{			
				$sql = "SELECT categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName, ".$this->table.". * From ".$this->table." INNER JOIN categories ON categories.id = ".$this->table.".category1 INNER JOIN manufacturer ON manufacturer.id = ".$this->table.".Manufacturer WHERE ".$this->table.".category2=? and (".$this->table.".Name LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer0 LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer LIKE '%".$search['text']."%' ESCAPE '!') ".$where." ORDER BY ".$this->table.".id DESC LIMIT ? , 99";
				$query = $this->db->query($sql,array($search['category2'], $start));
			}
			else
			{			
				$sql = 'SELECT categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName, '.$this->table.'. * From '.$this->table.' INNER JOIN categories ON categories.id = '.$this->table.'.category1 INNER JOIN manufacturer ON manufacturer.id = '.$this->table.'.Manufacturer WHERE '.$this->table.'.category2=? '.$where.' ORDER BY '.$this->table.'.id DESC LIMIT ? , 99';
				$query = $this->db->query($sql,array($search['category2'], $start));
			}
		}
		else if(isset($search['category3']))
		{
			if(isset($search['text']))
			{			
				$sql = "SELECT categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName, ".$this->table.". * From ".$this->table." INNER JOIN categories ON categories.id = ".$this->table.".category1 INNER JOIN manufacturer ON manufacturer.id = ".$this->table.".Manufacturer WHERE ".$this->table.".category3=? and (".$this->table.".Name LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer0 LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer LIKE '%".$search['text']."%' ESCAPE '!') ".$where." ORDER BY ".$this->table.".id DESC LIMIT ? , 99";
				$query = $this->db->query($sql,array($search['category3'], $start));
			}
			else
			{			
				$sql = 'SELECT categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName, '.$this->table.'. * From '.$this->table.' INNER JOIN categories ON categories.id = '.$this->table.'.category1 INNER JOIN manufacturer ON manufacturer.id = '.$this->table.'.Manufacturer WHERE '.$this->table.'.category3=? '.$where.' ORDER BY '.$this->table.'.id DESC LIMIT ? , 99';
				$query = $this->db->query($sql,array($search['category3'], $start));
			}
		}
		else if(isset($search['text']))
		{
			$sql = "SELECT categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName, ".$this->table.". * From ".$this->table." INNER JOIN categories ON categories.id = ".$this->table.".category1 INNER JOIN manufacturer ON manufacturer.id = ".$this->table.".Manufacturer WHERE (".$this->table.".Name LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer0 LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer LIKE '%".$search['text']."%' ESCAPE '!') ".$where." ORDER BY ".$this->table.".id DESC LIMIT ? , 99";
			$query = $this->db->query($sql,array($start));
		}
		else if(isset($search['Manufacturer']))
		{
			$sql = "SELECT categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName, ".$this->table.". * From ".$this->table." INNER JOIN categories ON categories.id = ".$this->table.".category1 INNER JOIN manufacturer ON manufacturer.id = ".$this->table.".Manufacturer WHERE ".$this->table.".Manufacturer=".$search['Manufacturer']." ORDER BY ".$this->table.".id DESC LIMIT ? , 99";
			$query = $this->db->query($sql,array($start));
		}
		return $query->result();
    }
	
	public function get_manu($search=NULL){
		
		if(isset($search['Manufacturer']))
			$where = 'and '.$this->table.'.Manufacturer='.$search['Manufacturer'];
		else
			$where = '';
			
		if(empty($search) || (count($search)==1 and isset($search['Manufacturer'])))
		{
	        $sql = 'SELECT manufacturer.name AS Mname, manufacturer.id AS MID, '.$this->table.'.id From '.$this->table.' INNER JOIN manufacturer ON manufacturer.id = '.$this->table.'.Manufacturer GROUP BY '.$this->table.'.Manufacturer';
			$query = $this->db->query($sql);
		}	
		else if(isset($search['category1']))
		{
			if(isset($search['text']))
			{			
				$sql = "SELECT manufacturer.name AS Mname, manufacturer.id AS MID, ".$this->table.".id From ".$this->table." INNER JOIN manufacturer ON manufacturer.id = ".$this->table.".Manufacturer WHERE ".$this->table.".category1=? and (".$this->table.".Name LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer0 LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer LIKE '%".$search['text']."%' ESCAPE '!') GROUP BY ".$this->table.".Manufacturer";
				$query = $this->db->query($sql,array($search['category1']));
			}
			else
			{			
				$sql = 'SELECT manufacturer.name AS Mname, manufacturer.id AS MID, '.$this->table.'.id From '.$this->table.' INNER JOIN manufacturer ON manufacturer.id = '.$this->table.'.Manufacturer WHERE '.$this->table.'.category1=? GROUP BY '.$this->table.'.Manufacturer';
				$query = $this->db->query($sql,array($search['category1']));
			}
		}
		else if(isset($search['category2']))
		{
			if(isset($search['text']))
			{			
				$sql = "SELECT manufacturer.name AS Mname, manufacturer.id AS MID, ".$this->table.".id From ".$this->table." INNER JOIN manufacturer ON manufacturer.id = ".$this->table.".Manufacturer WHERE ".$this->table.".category2=? and (".$this->table.".Name LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer0 LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer LIKE '%".$search['text']."%' ESCAPE '!') GROUP BY ".$this->table.".Manufacturer";
				$query = $this->db->query($sql,array($search['category2']));
			}
			else
			{			
				$sql = 'SELECT manufacturer.name AS Mname, manufacturer.id AS MID, '.$this->table.'.id From '.$this->table.' INNER JOIN manufacturer ON manufacturer.id = '.$this->table.'.Manufacturer WHERE '.$this->table.'.category2=? GROUP BY '.$this->table.'.Manufacturer';
				$query = $this->db->query($sql,array($search['category2']));
			}
		}
		else if(isset($search['category3']))
		{
			if(isset($search['text']))
			{			
				$sql = "SELECT manufacturer.name AS Mname, manufacturer.id AS MID, ".$this->table.".id From ".$this->table." INNER JOIN manufacturer ON manufacturer.id = ".$this->table.".Manufacturer WHERE ".$this->table.".category3=? and (".$this->table.".Name LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer0 LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer LIKE '%".$search['text']."%' ESCAPE '!') GROUP BY ".$this->table.".Manufacturer";
				$query = $this->db->query($sql,array($search['category3']));
			}
			else
			{			
				$sql = 'SELECT manufacturer.name AS Mname, manufacturer.id AS MID, '.$this->table.'.id From '.$this->table.' INNER JOIN manufacturer ON manufacturer.id = '.$this->table.'.Manufacturer WHERE '.$this->table.'.category3=? GROUP BY '.$this->table.'.Manufacturer';
				$query = $this->db->query($sql,array($search['category3']));
			}
		}
		else if(isset($search['text']))
		{
			$sql = "SELECT manufacturer.name AS Mname, manufacturer.id AS MID, ".$this->table.".id From ".$this->table." INNER JOIN manufacturer ON manufacturer.id = ".$this->table.".Manufacturer WHERE (".$this->table.".Name LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer0 LIKE '%".$search['text']."%' ESCAPE '!' OR ".$this->table.".RSKnummer LIKE '%".$search['text']."%' ESCAPE '!') GROUP BY ".$this->table.".Manufacturer";
			$query = $this->db->query($sql);
		}
		
		return $query->result();
    }
	
	public function random()
	{
		$sql = 'SELECT categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName, '.$this->table.'. * From '.$this->table.' INNER JOIN categories ON categories.id = '.$this->table.'.category1 INNER JOIN manufacturer ON manufacturer.id = '.$this->table.'.Manufacturer ORDER BY id DESC LIMIT 0 , 25';
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function recent()
	{
		$sql = 'SELECT categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName, '.$this->table.'. * From '.$this->table.' INNER JOIN categories ON categories.id = '.$this->table.'.category1 INNER JOIN manufacturer ON manufacturer.id = '.$this->table.'.Manufacturer ORDER BY '.$this->table.'.id DESC LIMIT 0 , 6';
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function related_products($id)
	{
		$sql = 'SELECT categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName, '.$this->table.'. * From '.$this->table.' INNER JOIN categories ON categories.id = '.$this->table.'.category1 INNER JOIN manufacturer ON manufacturer.id = '.$this->table.'.Manufacturer WHERE '.$this->table.'.ProductType=? ORDER BY id DESC LIMIT 0 , 10';
		$query = $this->db->query($sql,$id);
		return $query->result();
	}
	
	public function group_product($id)
	{
		$sql = 'SELECT categories.id AS CID, categories.name AS CNAME, manufacturer.name AS MName, '.$this->table.'.* From '.$this->table.' INNER JOIN categories ON categories.id = '.$this->table.'.category1 INNER JOIN manufacturer ON manufacturer.id = '.$this->table.'.Manufacturer WHERE '.$this->table.'.groupName='.$id.' ORDER BY id DESC LIMIT 0 , 4';	
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function category1()
	{
		$sql = 'SELECT categories.id, categories.name, COUNT('.$this->table.'.id) as pcount From '.$this->table.' INNER JOIN categories ON categories.id = '.$this->table.'.category1 GROUP BY '.$this->table.'.category1';
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function category2($pid)
	{
		$sql = 'SELECT categories.id, categories.name, COUNT('.$this->table.'.id) as pcount From '.$this->table.' INNER JOIN categories ON categories.id = '.$this->table.'.category2 WHERE pid=? AND `pid2` IS NULL GROUP BY '.$this->table.'.category2';
		$query = $this->db->query($sql,$pid);
		return $query->result();
	}
	
	public function category3($pid, $pid2)
	{
		$sql = 'SELECT categories.id, categories.name, COUNT('.$this->table.'.id) as pcount From '.$this->table.' INNER JOIN categories ON categories.id = '.$this->table.'.category3 WHERE pid=? AND `pid2`=? GROUP BY '.$this->table.'.category3';
		$query = $this->db->query($sql,array($pid, $pid2));
		return $query->result();
	}
	
	
	public function search($search,$limit=NULL)
	{
		$this->db->where($search);
		if(!empty($limit))
			$this->db->limit($limit);
		$query = $this->db->get($this->table);
        return $query->result();
	}

    public function get_all() {
		$this->db->order_by("id", "asc");
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function insert($insert) {       
//        $insert['created'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $insert);
		$insert_id = $this->db->insert_id();
	    return  $insert_id;
    }

    public function update($update, $id) {       
        $this->db->update($this->table, $update, array('id' => $id));
    }
	
	public function update_where($update, $where) {       
        $this->db->update($this->table, $update, $where);
    }

    public function delete($id){
        return $this->db->delete($this->table, array('id' => $id)); 
    }
}