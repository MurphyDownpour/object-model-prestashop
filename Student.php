<?php

class Student extends ObjectModel
{
    public $id;
    public $id_student;
    public $name;
    public $birth_date;
    public $is_studying;
    public $average_points;

    public static $definition = array(
        'table' => 'student',
        'primary' => 'id_student',
        'multilang' => true,
        'fields' => array(
            'name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 128),
            'birth_date' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true),
            'is_studying' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true),
            'average_points' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true)
        )
    );

    public function getAllStudents()
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('student');
        return Db::getInstance()->executeS($sql);
    }

    public function getHighestPoint()
    {
        $sql = new DbQuery();
        $sql->select('MAX(average_points)');
        $sql->from('student');
        $best_point = Db::getInstance()->executeS($sql);

        return $best_point;
    }

    public function getBestStudent()
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('student');
        $sql->where('average_points = (SELECT MAX(average_points) FROM student)');

        $best_student = Db::getInstance()->executeS($sql);
        return $best_student;
    }
}