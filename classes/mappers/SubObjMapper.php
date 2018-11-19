<?php
class SubObjMapper extends AbstractDataMapper implements ISubObjMapper
{
    protected $commentMapper;
    protected $entityTable = "SubObjs";
    protected $entityTableBase = "SubObjs";

    // public function __construct(DatabaseAdapterInterface $adapter,
    //     CommentMapperInterface $commenMapper) {
    //     $this->commentMapper = $commenMapper;
    //     parent::__construct($adapter);
    // }

    public function __construct(IDataBaseAdapter $adapter) {
        parent::__construct($adapter);
    }

    public function insert(ISubObj $subObj) {
        $subObj->id = $this->adapter->insert(
            $this->entityTable,
            array(
                "objName"    => $subObj->getName(),
                "dateSub"    => $subObj->getDate(),
            )
        );

        $this->adapter->insert(
            $this->entityTableBase,
            array(
                "subObjID"  => $subObj->id,
                "dateSub"   => $subObj->getDate(),
            )
        );

        return $subObj->id;
    }

    public function delete($id) {
        if ($id instanceof ISubObj) {
            $id = $id->id;
        }

        $this->adapter->delete($this->entityTable, "id = $id");
        return $this->commentMapper->delete("subObjID = $id");
    }

    protected function createEntity(array $row) {
        $comments = $this->commentMapper->findAll(
            array("subObjID" => $row["id"]));
        return new SubObj($row["name"], $row["date"], $comments);
    }
}

?>