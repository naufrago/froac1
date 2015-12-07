<?php

class Rss_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_rss_feeds() {
        $query = $this->db->query('select rss.idnotice, repository.name, rss.notice_title from rss, repository where repository.idrepository=rss.idrepository');
        return $query->result_array();
    }

    public function get_oas($search) {
        $query = $this->db->query("select repository.name, repository.idrepository, lom.general_title,
rss.notice_title,technical_location.location from lo,lom,repository,rss,technical_location
where lo.idlom=lom.idlom and technical_location.idlom=lom.idlom and technical_location.idrepository=lom.idrepository
and repository.idrepository=lom.idrepository  and rss.idrepository=lom.idrepository and
lo.lastmodified::date=rss.noticedate  and rss.idnotice='" . $search . "' limit 10");
        return $query->result_array();
    }

}

