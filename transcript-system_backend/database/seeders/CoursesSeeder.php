<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesSeeder extends Seeder
{
    public function run()
    {

        $courses = [
   // Semester 1
            ['code' => 'MATH123', 'title' => 'DISCRETE MATHEMATICS', 'credits' => 3, 'category' => 'FC', 'semester' => 1, 'ects' => 5],
            ['code' => 'PHYS121', 'title' => 'PHYSICS-I', 'credits' => 3, 'category' => 'FC', 'semester' => 1, 'ects' => 5],
            ['code' => 'MATH121', 'title' => 'CALCULUS-I', 'credits' => 4, 'category' => 'FC', 'semester' => 1, 'ects' => 6],
            ['code' => 'ENGR101', 'title' => 'INFORMATION TECHNOLOGY AND APPLICATIONS', 'credits' => 2, 'category' => 'FC', 'semester' => 1, 'ects' => 2],
            ['code' => 'ENGR103', 'title' => 'COMPUTER PROGRAMMING-I', 'credits' => 3, 'category' => 'FC', 'semester' => 1, 'ects' => 5],
            ['code' => 'ENGL121', 'title' => 'ENGLISH-I', 'credits' => 3, 'category' => 'UC', 'semester' => 1, 'ects' => 4],
            ['code' => 'TUOG101', 'title' => 'TURKISH LANGUAGE-I', 'credits' => 2, 'category' => 'UC', 'semester' => 1, 'ects' => 3],
            ['code' => 'TURK131', 'title' => 'TURKISH AS A FOREIGN LANGUAGE-I', 'credits' => 2, 'category' => 'UC', 'semester' => 1, 'ects' => 3],
            
            // Semester 2
            ['code' => 'MATH122', 'title' => 'CALCULUS-II', 'credits' => 4, 'category' => 'FC', 'semester' => 2, 'ects' => 6],
            ['code' => 'MATH124', 'title' => 'LINEAR ALGEBRA', 'credits' => 3, 'category' => 'FC', 'semester' => 2, 'ects' => 5],
            ['code' => 'PHYS122', 'title' => 'PHYSICS-II', 'credits' => 4, 'category' => 'FC', 'semester' => 2, 'ects' => 5],
            ['code' => 'ENGR104', 'title' => 'COMPUTER PROGRAMMING-II', 'credits' => 3, 'category' => 'FC', 'semester' => 2, 'ects' => 4],
            ['code' => 'ENGL122', 'title' => 'ENGLISH-II', 'credits' => 3, 'category' => 'UC', 'semester' => 2, 'ects' => 4],
            ['code' => 'TARH101', 'title' => 'ATATURK\'S PRINCIPLES AND HISTORY OF TURKISH REFORMS-I', 'credits' => 2, 'category' => 'UC', 'semester' => 2, 'ects' => 3],
            ['code' => 'HIST111', 'title' => 'ATATURK\'S PRINCIPLES AND HISTORY OF TURKISH REFORMS-I', 'credits' => 2, 'category' => 'UC', 'semester' => 2, 'ects' => 3],
            ['code' => 'TUOG102', 'title' => 'TURKISH LANGUAGE-II', 'credits' => 2, 'category' => 'UC', 'semester' => 2, 'ects' => 3],
            ['code' => 'TURK132', 'title' => 'TURKISH AS A FOREIGN LANGUAGE-II', 'credits' => 2, 'category' => 'UC', 'semester' => 2, 'ects' => 3],
            
            // Semester 3
            ['code' => 'ELEE211', 'title' => 'DIGITAL LOGIC DESIGN', 'credits' => 4, 'category' => 'AC', 'semester' => 3, 'ects' => 6],
            ['code' => 'ELEE231', 'title' => 'CIRCUIT THEORY-I', 'credits' => 4, 'category' => 'AC', 'semester' => 3, 'ects' => 6],
            ['code' => 'CMPE215', 'title' => 'ALGORITHMS AND DATA STRUCTURES', 'credits' => 3, 'category' => 'AC', 'semester' => 3, 'ects' => 6],
            ['code' => 'MATH225', 'title' => 'DIFFERENTIAL EQUATIONS', 'credits' => 4, 'category' => 'FC', 'semester' => 3, 'ects' => 5],
            ['code' => 'TARH102', 'title' => 'ATATURK\'S PRINCIPLES AND HISTORY OF TURKISH REFORMS-II', 'credits' => 2, 'category' => 'UC', 'semester' => 3, 'ects' => 3],
            ['code' => 'HIST112', 'title' => 'ATATURK\'S PRINCIPLES AND HISTORY OF TURKISH REFORMS-II', 'credits' => 2, 'category' => 'UC', 'semester' => 3, 'ects' => 3],
            
            // Semester 4
            ['code' => 'CMPE216', 'title' => 'OBJECT ORIENTED PROGRAMMING', 'credits' => 3, 'category' => 'AC', 'semester' => 4, 'ects' => 6],
            ['code' => 'CMPE232', 'title' => 'OPERATING SYSTEMS', 'credits' => 3, 'category' => 'AC', 'semester' => 4, 'ects' => 6],
            ['code' => 'CMPE252', 'title' => 'ANALYSIS OF ALGORITHMS', 'credits' => 4, 'category' => 'AC', 'semester' => 4, 'ects' => 6],
            ['code' => 'ENGR215', 'title' => 'RESEARCH METHODS FOR ENGINEERING AND ARCHITECTURE', 'credits' => 2, 'category' => 'FC', 'semester' => 4, 'ects' => 3],
            ['code' => 'STAT226', 'title' => 'PROBABILITY AND STATISTICS', 'credits' => 3, 'category' => 'FC', 'semester' => 4, 'ects' => 6],
            ['code' => 'OHSA206', 'title' => 'OCCUPATIONAL HEALTH AND SAFETY', 'credits' => 3, 'category' => 'FC', 'semester' => 4, 'ects' => 3],
            
            // Semester 5
            ['code' => 'CMPE321', 'title' => 'MICROPOCESSORS', 'credits' => 4, 'category' => 'AC', 'semester' => 5, 'ects' => 6],
            ['code' => 'CMPE341', 'title' => 'DATABASE SYSTEMS', 'credits' => 4, 'category' => 'AC', 'semester' => 5, 'ects' => 5],
            ['code' => 'SFWE343', 'title' => 'SOFTWARE ANALYSIS AND DESIGN', 'credits' => 3, 'category' => 'AC', 'semester' => 5, 'ects' => 5],
            ['code' => 'SFWE315', 'title' => 'VISUAL PROGRAMMING', 'credits' => 3, 'category' => 'AC', 'semester' => 5, 'ects' => 5],
            
            // Semester 6
            ['code' => 'SFWE344', 'title' => 'SOFTWARE PROJECT MANAGEMENT', 'credits' => 2, 'category' => 'AC', 'semester' => 6, 'ects' => 4],
            ['code' => 'MATH328', 'title' => 'NUMERICAL ANALYSIS', 'credits' => 3, 'category' => 'FC', 'semester' => 6, 'ects' => 6],
            
            // Semester 7
            ['code' => 'SFWE403', 'title' => 'SUMMER TRAINING', 'credits' => 0, 'category' => 'AC', 'semester' => 7, 'ects' => 2],
            ['code' => 'ENGR401', 'title' => 'ENGINEERING DESIGN-I', 'credits' => 2, 'category' => 'FC', 'semester' => 7, 'ects' => 6],
            ['code' => 'SFWE415', 'title' => 'SOFTWARE ARCHITECTURE', 'credits' => 3, 'category' => 'AC', 'semester' => 7, 'ects' => 6],
            
            // Semester 8
            ['code' => 'SFWE411', 'title' => 'SOFTWARE VALIDATION AND TESTING', 'credits' => 3, 'category' => 'AC', 'semester' => 8, 'ects' => 6],
            ['code' => 'ENGR402', 'title' => 'ENGINEERING DESIGN-II', 'credits' => 2, 'category' => 'FC', 'semester' => 8, 'ects' => 10],
            ['code' => 'ENGR404', 'title' => 'ENGINEERING ATTRIBUTES AND ETHICS', 'credits' => 2, 'category' => 'FC', 'semester' => 8, 'ects' => 3],
            
            // Area Elective Courses
            ['code' => 'SFWE316', 'title' => 'INTERNET AND WEB PROGRAMMING', 'credits' => 3, 'category' => 'AE', 'semester' => null, 'ects' => 6],
            ['code' => 'SFWE434', 'title' => 'CRYPTOGRAPHY', 'credits' => 3, 'category' => 'AE', 'semester' => null, 'ects' => 6],
            ['code' => 'SFWE412', 'title' => 'SOFTWARE QUALITY ASSURANCE', 'credits' => 3, 'category' => 'AE', 'semester' => null, 'ects' => 6],
            ['code' => 'SFWE422', 'title' => 'MOBILE APPLICATION DEVELOPMENT', 'credits' => 3, 'category' => 'AE', 'semester' => null, 'ects' => 6],
            ['code' => 'SFWE431', 'title' => 'HUMAN-COMPUTER INTERACTION', 'credits' => 3, 'category' => 'AE', 'semester' => null, 'ects' => 6],
            ['code' => 'SFWE441', 'title' => 'ADVANCE DATABASE', 'credits' => 3, 'category' => 'AE', 'semester' => null, 'ects' => 6],
            ['code' => 'SFWE442', 'title' => 'OBJECT-ORIENTED PROGRAMMING LANGUAGE AND SYSTEMS', 'credits' => 3, 'category' => 'AE', 'semester' => null, 'ects' => 6],
            ['code' => 'SFWE444', 'title' => 'SOFTWARE CONSTRUCTION', 'credits' => 3, 'category' => 'AE', 'semester' => null, 'ects' => 6],
            ['code' => 'SFWE445', 'title' => 'RAPID APPLICATION DEVELOPMENT', 'credits' => 3, 'category' => 'AE', 'semester' => null, 'ects' => 6],
            ['code' => 'SFWE451', 'title' => 'INFORMATION RETRIEVAL', 'credits' => 3, 'category' => 'AE', 'semester' => null, 'ects' => 6],
            ['code' => 'SFWE467', 'title' => 'DATA MINING', 'credits' => 3, 'category' => 'AE', 'semester' => null, 'ects' => 6],
            ['code' => 'SFWE468', 'title' => 'PROCESS MINING', 'credits' => 3, 'category' => 'AE', 'semester' => null, 'ects' => 6],
            ['code' => 'SFWE472', 'title' => 'COMPUTER GRAPHICS', 'credits' => 3, 'category' => 'AE', 'semester' => null, 'ects' => 6],
            ['code' => 'SFWE474', 'title' => 'INTRODUCTION TO PARALLEL COMPUTING', 'credits' => 3, 'category' => 'AE', 'semester' => null, 'ects' => 6],
            
            // Faculty Elective Courses
            ['code' => 'CMPE431', 'title' => 'ADVANCED COMPUTER NETWORKS', 'credits' => 3, 'category' => 'FE', 'semester' => null, 'ects' => 6],
            ['code' => 'CMPE432', 'title' => 'WIRELESS COMMUNICATION NETWORKS', 'credits' => 3, 'category' => 'FE', 'semester' => null, 'ects' => 6],
            ['code' => 'CMPE433', 'title' => 'WIRELESS SENSOR NETWORKS', 'credits' => 3, 'category' => 'FE', 'semester' => null, 'ects' => 6],
            ['code' => 'CMPE461', 'title' => 'COMPUTING SYSTEMS', 'credits' => 3, 'category' => 'FE', 'semester' => null, 'ects' => 6],
            ['code' => 'CMPE462', 'title' => 'SERVICE-ORIENTED COMPUTING', 'credits' => 3, 'category' => 'FE', 'semester' => null, 'ects' => 6],
            ['code' => 'CMPE463', 'title' => 'CLOUD COMPUTING', 'credits' => 3, 'category' => 'FE', 'semester' => null, 'ects' => 6],
            ['code' => 'CMPE464', 'title' => 'ARTIFICIAL INTELLIGENCE', 'credits' => 3, 'category' => 'FE', 'semester' => null, 'ects' => 6],
            ['code' => 'CMPE465', 'title' => 'NEURAL NETWORKS', 'credits' => 3, 'category' => 'FE', 'semester' => null, 'ects' => 6],
            ['code' => 'CMPE466', 'title' => 'EXPERT SYSTEMS', 'credits' => 4, 'category' => 'FE', 'semester' => null, 'ects' => 6],
            ['code' => 'CHEM121', 'title' => 'CHEMISTRY', 'credits' => 3, 'category' => 'FE', 'semester' => null, 'ects' => 5],
            ['code' => 'MATH228', 'title' => 'ENGINEERING MATHEMATICS', 'credits' => 3, 'category' => 'FE', 'semester' => null, 'ects' => 6],
            ['code' => 'ELEE341', 'title' => 'ELECTRONICS-I', 'credits' => 4, 'category' => 'FE', 'semester' => null, 'ects' => 6],
            ['code' => 'ELEE331', 'title' => 'SIGNALS AND SYSTEMS', 'credits' => 4, 'category' => 'FE', 'semester' => null, 'ects' => 6],
            ['code' => 'ELEE362', 'title' => 'COMMUNICATION SYSTEMS', 'credits' => 3, 'category' => 'FE', 'semester' => null, 'ects' => 5],
            ['code' => 'ELEE431', 'title' => 'DIGITAL SIGNAL PROCESSING', 'credits' => 3, 'category' => 'FE', 'semester' => null, 'ects' => 6],
            ['code' => 'CMPE322', 'title' => 'DATA COMMUNICATION AND COMPUTER NETWORKS', 'credits' => 4, 'category' => 'FE', 'semester' => null, 'ects' => 6],
            ['code' => 'MECE215', 'title' => 'BASIC MECHANICS: STATICS', 'credits' => 3, 'category' => 'FE', 'semester' => null, 'ects' => 5],
        ];
        
        // Insert data in batches of 20 records
        $chunks = array_chunk($courses, 20);
        foreach ($chunks as $chunk) {
            DB::table('courses')->insert($chunk);
        }
    }
}

