<?php
namespace Model;
/**
 * MusicModel Class
 * Provides access to the "MusicModel" database table.
 *
 */

class MusicModel
{

    // database connection and table name
    private $conn;
    private $table_name = "music_cd";

    // object properties
    public $id;
    public $artist_name;
    public $album_title;
    public $album_catalog_no;
    public $release_year;
    public $genre;
    public $composer;
    public $owner;

    // constructor with $db as database connection
    public function __construct(){
        $database = new \Database();
        $db = $database->getConnection();
        $this->conn = $db;
    }

    function findAll() {
        // select all query
        $query = "SELECT
                m.id as cd_id,
                m.artist_name as cd_artist_name,
                m.album_title as cd_album_title,
                m.release_year as cd_release_year,
                m.album_catalog_no as cd_album_catalog_no,
                m.genre as cd_genre,
                m.composer as cd_composer,
                m.owner as cd_owner
            FROM
                " . $this->table_name . " m
            ORDER BY
                m.created DESC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    /**
     * Find data by column name
     *
     * @param null $ColumnName
     * @param null $ColumnValue
     * @return mixed
     */
    function findByColumn($ColumnName = NULL, $ColumnValue = NULL) {
        if (!empty($ColumnName) && !empty($ColumnValue)) {
            $query = "SELECT
                m.id as cd_id,
                m.artist_name as cd_artist_name,
                m.album_title as cd_album_title,
                m.release_year as cd_release_year,
                m.album_catalog_no as cd_album_catalog_no,
                m.genre as cd_genre,
                m.composer as cd_composer,
                m.owner as cd_owner
            FROM
                " . $this->table_name . " m
                WHERE m.$ColumnName = $ColumnValue
            ORDER BY
                m.created DESC";

            // prepare query statement
            $returnData = $this->conn->prepare($query);

            // execute query
            $returnData->execute();
            return $returnData->fetch(); //return single row
        }
    }

    /**
     * @param array $data
     * @return bool|mixed
     */
    function addRecord($data = array()) {
        $query = "INSERT into " . $this->table_name . "
                SET
                artist_name = $data->cd_artist_name, 
                album_title = $data->cd_album_title, 
                release_year = $data->cd_release_year, 
                album_catalog_no = $data->cd_album_catalog_no, 
                genre = $data->cd_genre, 
                composer = $data->cd_composer, 
                owner = $data->cd_owner, 
                created= date('Y-m-d H:i:s')";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize all, example
        $this->artist_name = htmlspecialchars(strip_tags($this->cd_artist_name));

        // execute query
        if($stmt->execute()){
            return $stmt->fetchColumn('id');
        }

        return false;
    }

    function deleteRecord(int $id) {
        // delete query
        $this->id = $id;
        $query = "DELETE FROM " . $this->table_name . " WHERE id = $id";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

}
