<?php

/*****
*
* @Author: Nasid Kamal.
* @Project Keyword: OHS.
*
*****/

defined('BASEPATH') OR exit('No direct script access allowed');

class Plumbing_service_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get plumbing_service by id
     */
    function get_plumbing_service($id)
    {
        $plumbing_service = $this->db->query("
            SELECT
                *

            FROM
                `plumbing_services`

            WHERE
                `id` = ?
        ",array($id))->row_array();

        return $plumbing_service;
    }
    
    /*
     * Get all plumbing_services count
     */
    function get_all_plumbing_services_count()
    {
        $plumbing_services = $this->db->query("
            SELECT
                count(*) as count

            FROM
                `plumbing_services`
        ")->row_array();

        return $plumbing_services['count'];
    }
        
    /*
     * Get all plumbing_services
     */
    function get_all_plumbing_services($params = array())
    {
        $limit_condition = "";
        if(isset($params) && !empty($params))
            $limit_condition = " LIMIT " . $params['offset'] . "," . $params['limit'];
        
        $plumbing_services = $this->db->query("
            SELECT
                *

            FROM
                `plumbing_services`

            WHERE
                1 = 1

            ORDER BY `title` ASC

            " . $limit_condition . "
        ")->result_array();

        return $plumbing_services;
    }
        
    /*
     * function to add new plumbing_service
     */
    function add_plumbing_service($params)
    {
        $this->db->insert('plumbing_services',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update plumbing_service
     */
    function update_plumbing_service($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('plumbing_services',$params);
    }
    
    /*
     * function to delete plumbing_service
     */
    function delete_plumbing_service($id)
    {
        return $this->db->delete('plumbing_services',array('id'=>$id));
    }
}
