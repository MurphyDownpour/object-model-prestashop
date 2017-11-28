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
        $best_point = 0;

        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('student');

        $students = Db::getInstance()->executeS($sql);

        foreach($students as $student)
        {
            if ($student['average_points'] > $best_point)
                $best_point = $student['average_points'];
            else
                continue;
        }
        return $best_point;
    }

    public function getBestStudent()
    {
        $best_point = 0;
        $best_student = null;

        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('student');

        $students = Db::getInstance()->executeS($sql);

        foreach($students as $student)
        {
            if ($student['average_points'] > $best_point)
            {
                $best_point = $student['average_points'];
                $best_student = $student;
            }
            else
                continue;
        }
        return $best_student;
    }
}