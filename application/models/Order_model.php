<?php

    /*****
    *
    * @Author: Nasid Kamal.
    *
    *****/

    defined('BASEPATH') OR exit('No direct script access allowed');

/********************************************************************/



class Order_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

     /*
     * Get orders count
     */
    function get_count() {

        return $this->db->count_all('orders');
    }
    
    /*
     * Get order by id
     */
    function get_order($id)
    {
        return $this->db->get_where('orders',array('id'=>$id))->row_array();
    }
    
    /*
     * Get all orders
     */
    function get_all_orders()
    {
        return $this->db->get('orders')->result_array();
    }

    function get_orders($limit, $start)
    {
        $this->db->limit($limit, $start);
        return $this->db->get('orders')->result_array();
    }
    
    /*
     * function to add new order
     */
    function add_order($params)
    {
        $this->db->insert('orders',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update order
     */
    function update_order($id,$params)
    {
        $this->db->where('id',$id);
        $response = $this->db->update('orders',$params);
        if($response)
        {
            return "order updated successfully";
        }
        else
        {
            return "Error occuring while updating order";
        }
    }
    
    /*
     * function to delete order
     */
    function delete_order($id)
    {
        $response = $this->db->delete('orders',array('id'=>$id));
        if($response)
        {
            return "order deleted successfully";
        }
        else
        {
            return "Error occuring while deleting order";
        }
    }

    function pullCount($query_rules) {

        $where = array();

        if($query_rules['fid'] > 0) {

                $where['facilityId'] = $query_rules['fid'];

        }
        if($query_rules['rpid'] > 0) {

                $where['referringPhysicianId'] = $query_rules['rpid'];

        }

        if($query_rules['tid'] > 0) {

            $where['techId'] = $query_rules['tid'];

        }

        if($query_rules['dateFrom'] != null || $query_rules['dateFrom'] != '') {

            $where['scheduledTime >= '] = $query_rules['dateFrom'];

        }

        if($query_rules['dateTo'] != null || $query_rules['dateTo'] != '') {

            $where['scheduledTime <= '] = $query_rules['dateTo'];

        }

        if(!empty($where)) {
            $this->db->where($where);
        }

        $count = $this->db->count_all_results('orders');

        return $count;

    }

    function pullOrders($query_rules, $limit, $start) {

        $where = array();

        if($query_rules['fid'] > 0) {

                $where['facilityId'] = $query_rules['fid'];

        }
        if($query_rules['rpid'] > 0) {

                $where['referringPhysicianId'] = $query_rules['rpid'];

        }

        if($query_rules['tid'] > 0) {

            $where['techId'] = $query_rules['tid'];

        }

        if($query_rules['dateFrom'] != null || $query_rules['dateFrom'] != '') {

            $where['scheduledTime >= '] = $query_rules['dateFrom'];

        }

        if($query_rules['dateTo'] != null || $query_rules['dateTo'] != '') {

            $where['scheduledTime <= '] = $query_rules['dateTo'];

        }

        $this->db->select('*')
                 ->from('orders');

        if(!empty($where)) {
            $this->db->where($where);
        }
        if(!($limit == 0 && $start == 0)) {
            $this->db->limit($limit, $start);
        }
        
        $this->db->order_by($query_rules['sortBy'], $query_rules['sortingOrder']);
        $query = $this->db->get();

        $results = $query->result_array();

        return $results;

    }

    function pullOrderIDs($query_rules) {

        $where = array();

        if($query_rules['fid'] > 0) {

                $where['facilityId'] = $query_rules['fid'];

        }
        if($query_rules['rpid'] > 0) {

                $where['referringPhysicianId'] = $query_rules['rpid'];

        }

        if($query_rules['tid'] > 0) {

            $where['techId'] = $query_rules['tid'];

        }

        if($query_rules['dateFrom'] != null || $query_rules['dateFrom'] != '') {

            $where['scheduledTime >= '] = $query_rules['dateFrom'];

        }

        if($query_rules['dateTo'] != null || $query_rules['dateTo'] != '') {

            $where['scheduledTime <= '] = $query_rules['dateTo'];

        }

        $this->db->select('id')
                 ->from('orders');

        if(!empty($where)) {
            $this->db->where($where);
        }
        
        $this->db->order_by($query_rules['sortBy'], $query_rules['sortingOrder']);
        $query = $this->db->get();

        $results = $query->result_array();

        return $results;

    }

}
