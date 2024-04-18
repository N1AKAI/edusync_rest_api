<?php

namespace App\Repository;

use App\Base\BaseRepository;

class BranchRepository extends BaseRepository
{

  protected $showableFields = ['branch_id', 'branch_name'];

  protected $insertableFields = ['branch_id', 'branch_name'];

  protected $updatableFields = ['branch_id', 'branch_name'];
  protected $columnId = "branch_id";

  function __construct()
  {
    parent::__construct("branch");
  }
}
