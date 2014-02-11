<?php 

class Core_Model_Mapper_User
{
    public function find($id)
    {
        $dbTable = new Core_Model_DbTable_Author();
        $rowset = $dbTable->find($id);
        $row = $rowset->current();

        $author = new Core_Model_Author();
        $author->setAuthorId($row->author_id);
        $author->setAuthorName($row->author_name);

        return $author;
    }
    
    public function fetchAllAuthor($user_id){
        $dbTable = new Core_Model_DbTable_Author();
        $select = $dbTable->select();
        $select->where('user_id = ?', $user_id);
        $rowset = $dbTable->fetchAll($select);
        
        $authors = array();
        foreach($rowset as $row){
            $author = new Core_Model_Author();
            $author->setAuthorId($row->author_id);
            $author->setAuthorName($row->author_name);
            $authors[] = $author;
        }
        return $authors;
    }

}