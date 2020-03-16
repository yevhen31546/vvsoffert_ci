<?php

/*****
*
* @Author: Nasid Kamal.
* @Project Keyword: OHS.
*
*****/

defined('BASEPATH') OR exit('No direct script access allowed');

class Plumbing_service_price_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get plumbing_service_price by id
     */
    function get_plumbing_service_price($id)
    {
        $plumbing_service_price = $this->db->query("
            SELECT
                *

            FROM
                `plumbing_service_prices`

            WHERE
                `id` = ?
        ",array($id))->row_array();

        return $plumbing_service_price;
    }

    /*
     * Get plumbing_service_price by psId
     */
    function get_plumbing_service_prices($psId)
    {
        $plumbing_service_prices = $this->db->query("
            SELECT
                *

            FROM
                `plumbing_service_prices`

            WHERE
                `psId` = ?

            ORDER BY `rskNumber` ASC
        ",array($psId))->result_array();

        return $plumbing_service_prices;
    }
    
    /*
     * Get all plumbing_service_prices count
     */
    function get_all_plumbing_service_prices_count()
    {
        $plumbing_service_prices = $this->db->query("
            SELECT
                count(*) as count

            FROM
                `plumbing_service_prices`
        ")->row_array();

        return $plumbing_service_prices['count'];
    }
        
    /*
     * Get all plumbing_service_prices
     */
    function get_all_plumbing_service_prices($params = array())
    {
        /*$limit_condition = "";
        if(isset($params) && !empty($params))
            $limit_condition = " LIMIT " . $params['offset'] . "," . $params['limit'];
        
        $plumbing_service_prices = $this->db->query("
            SELECT
                *

            FROM
                `plumbing_service_prices`

            WHERE
                1 = 1

            ORDER BY `id` ASC

            " . $limit_condition . "
        ")->result_array();*/

        $this->db->select('plumbing_service_prices.*, plumbing_services.title AS serviceTitle')
                 ->from('plumbing_service_prices')
                 ->join('plumbing_services', 'plumbing_services.id = plumbing_service_prices.psId');

        if(isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }

        $this->db->order_by('psId', 'ASC');


        $query = $this->db->get();
        
        $plumbing_service_prices = $query->result_array();

        return $plumbing_service_prices;
    }
        
    /*
     * function to add new plumbing_service_price
     */
    function add_plumbing_service_price($params)
    {
        $this->db->insert('plumbing_service_prices',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update plumbing_service_price
     */
    function update_plumbing_service_price($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('plumbing_service_prices',$params);
    }
    
    /*
     * function to delete plumbing_service_price
     */
    function delete_plumbing_service_price($id)
    {
        return $this->db->delete('plumbing_service_prices',array('id'=>$id));
    }
}
