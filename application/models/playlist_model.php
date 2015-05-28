<?php

include_once APPPATH . 'classes/VideoDTO.php';
include_once APPPATH . 'classes/VideoListDto.php';
include_once APPPATH . 'classes/PlaylistDTO.php';
include_once APPPATH . 'classes/PlaylistListDTO.php';

class Playlist_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "playlist";
    }

    public function push($idUser, $name, $isWatchLater) {
        $data["name"] = $name;
        $data["idUser"] = $idUser;
        $data["isWatchLater"] = $isWatchLater;
        $result = $this->save($data);
        return ($result > 0) ? true : false;
    }

    public function remove($idPlaylist) {
        $cond["id"] = $idPlaylist;
        $result = $this->delete($cond);
        return ($result > 0) ? true : false;
    }

    public function edit($id, $name, $isWatchLater) {
        if ($name !== "")
            $data["name"] = $name;
        if ($isWatchLater !== "")
            $data["isWatchLater"] = $isWatchLater;
        $result = $this->update($data, "id=" . $id);
        return ($result > 0) ? true : false;
    }

    public function selectById($idPlaylist) {
        $this->db->select("idVideo, playlist.isWatchLater, idChannel, video.name, link, date, durationInSeconds, active, playlist.name as pname");
        $this->db->join("video", "video.id = videoplaylist.idVideo");
        $this->db->join("playlist", "playlist.id = videoplaylist.idPlaylist");
        $conditions["playlist.id"] = $idPlaylist;
        
        $result = $this->search($conditions, "videoplaylist");
        $PlayList = new PlaylistDTO();
        $videoList = new VideoListDto();
        
        foreach ($result as $row) {
            $video = new VideoDTO();
            $video->id = $row->idVideo;
            $video->idChannel = $row->idChannel;
            $video->name = $row->name;
            $video->link = $row->link;
            $video->date = $row->date;
            $video->duration = $row->durationInSeconds;
            $video->active = $row->active;
            $videoList->addVideo($video);
        }
        $PlayList->videos = $videoList;
        $PlayList->id = $idPlaylist;
        $PlayList->isWatchLater = $result[0]->isWatchLater;
        $PlayList->name = $result[0]->pname; 
        return $PlayList;
    }

    public function selectByName($name) {
        $this->db->select("isWatchLater, video.id, idChannel, video.name, link, date, durationInSeconds, active, playlist.id as pid");
        $this->db->join("video", "video.id = videoplaylist.idVideo");
        $this->db->join("playlist", "playlist.id = videoplaylist.idPlaylist");
        $conditions["playlist.name"] = $name;
        $this->search($conditions, "videoplaylist");
        $PlayList = new PlaylistListDTO();
        $videoList = new VideoListDto();
        $PlayList->isWatchLater = $result[0]->isWatchLater;
        $PlayList->id = $result[0]->pid;
        $PlayList->name = $name; 
        foreach ($result as $row) {
            $video = new VideoDTO();
            $video->id = $row->video.id;
            $video->idChannel = $row->idChannel;
            $video->name = $row->name;
            $video->link = $row->link;
            $video->date = $row->date;
            $video->duration = $row->durationInSeconds;
            $video->active = $row->active;
            $videoList->addVideo($video);
        }
        $PlayList->videos = $videoList;
        return $PlayList;
    }

    public function addVideoToPlaylist($idPlaylist, $idVideo) {
        $data["idPlaylist"] = $idPlaylist;
        $data["idVideo"] = $idUser;
        $result = $this->insert($data, "videoplaylist");
        return ($result > 0) ? true : false;
    }

    public function removeVideoFromPlaylist($idVideo, $idPlaylist) {
        $cond["idVideo"] = $idVideo;
        $cond["idPlaylist"] = $idPlaylist;
        $result = $this->delete($cond, "videoplaylist");
        return ($result > 0) ? true : false;
    }

    public function selectPlaylistsByUser($idUser) {
        $cond["idUser"] = $idUser;
        $this->db->select("id, name, isWatchLater");
        $result = $this->search($cond);
        $PlaylistList = new PlaylistListDTO();

        foreach ($result as $row) {
            $Playlist = new PlaylistDTO;
            $Playlist->id = $row->id;
            $Playlist->name = $row->name;
            $Playlist->isWatchLater = $row->isWatchLater;
            $resultV = $this->selectById($Playlist->id);
            $Playlist->videos = $resultV->videos;
            $PlaylistList->addPlayList($Playlist);
        }
        return $PlaylistList;
    }

}
