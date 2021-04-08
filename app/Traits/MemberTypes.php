<?php


namespace App\Traits;


trait MemberTypes
{
    static private $sacMemberType = [
        'Advisor',
        'Student-Coordinator',
        'Co-Coordinator',
        'Secretary',
        'Joint-Secretary',
        'Executive',
        'Member',
    ];

    static private $executiveMemberType = [
        'President',
        'Vice-President',
        'Secretary',
        'Joint-Secretary',
        'Treasurer',
        'Member',
    ];

    static private $executiveMember = "'President', 'Vice-President', 'Secretary', 'Joint-Secretary', 'Treasurer', 'Member'";

    static private $sacMemberOrderBy = "'Advisor', 'Student-Coordinator', 'Co-Coordinator', 'Secretary', 'Joint-Secretary', 'Executive', 'Member'";

    static private $memberOrderBy = "'Advisor', 'President', 'Student-Coordinator', 'Vice-President', 'Co-Coordinator', 'Secretary', 'Joint-Secretary', 'Executive', 'Treasurer', 'Member'";
}
