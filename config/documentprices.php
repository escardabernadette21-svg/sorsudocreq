<?php

/**
 * Document prices configuration file.
 *
 * This file contains the prices for various document types that can be requested by students.
 * The prices are used in the DocumentRequestController to calculate the total amount for a request.
 */

return [
    // Certification
    'Grades' => 25,
    'Graduation' => 25,
    'GoodMoral' => 25,
    'Enrollment' => 25,
    'GWA' => 25,
    'Honors Awarded' => 25,
    'Medium of Instruction' => 25,
    'Units Earned' => 25,
    'Subject Enrolled' => 25,
    'Subject Description' => 25,
    'Others' => 25,

    // Academic Forms
    'Shifting Form' => 100,
    'Dropping/Adding/Changing' => 50,
    'Completion/Removal' => 50,

    // Other Services
    'Authentication' => 5,
    'Evaluation' => 15,
    'Documentary Stamp' => 30,

    //Credential's Fee
    'Transcript of Records' => 50,
    'Honorable Dismissal' => 25,
    'Reconstructed Diploma' => 100,
    'Form 137-A' => 50,
    'Certificate of Registration' => 25,
    'CAV' => 80,
    'Correction of Data' => 60,
    'ID' => 150,
];
