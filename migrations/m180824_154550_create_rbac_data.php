<?php

use yii\db\Migration;
use app\models\User;
use app\rbac\AuthorRule;


/**
 * Class m180824_154550_create_rbac_data
 */
class m180824_154550_create_rbac_data extends Migration
{

  /**
   * {@inheritdoc}
   */
  public function safeUp()
  {
    $auth = \Yii::$app->authManager;
    $rule = new AuthorRule();
    $auth->add($rule);

    // Define permissions 
    $managePosts = $auth->createPermission('managePosts');
    $manageCategories = $auth->createPermission('manageCategories');
    $manageComments = $auth->createPermission('manageComments');
    $manageTags = $auth->createPermission('manageTags');
    $createComments = $auth->createPermission('createComments');
    $editComments = $auth->createPermission('editComments');
    $editOwnComments = $auth->createPermission('editOwnComments');
    $deleteComments = $auth->createPermission('deleteComments');
    $deleteUser = $auth->createPermission('deleteUser');
    $updateUser = $auth->createPermission('updateUser');

    $auth->add($managePosts);
    $auth->add($manageCategories);
    $auth->add($manageComments);
    $auth->add($manageTags);
    $auth->add($createComments);
    $auth->add($editComments);
    $editOwnComments->ruleName = $rule->name;
    $auth->add($editOwnComments);
    $auth->add($deleteComments);
    $auth->add($deleteUser);
    $auth->add($updateUser);

    // Define roles with permissions 
    $userRole = $auth->createRole('user');
    $auth->add($userRole);

    $auth->addChild($userRole, $createComments);
    $auth->addChild($userRole, $deleteComments);

    $moderatorRole = $auth->createRole('moderator');
    $auth->add($moderatorRole);
    
    $auth->addChild($moderatorRole, $userRole);
    $auth->addChild($moderatorRole, $editComments);
    $auth->addChild($moderatorRole, $managePosts);
    $auth->addChild($moderatorRole, $manageCategories);
    $auth->addChild($moderatorRole, $manageComments);
    $auth->addChild($moderatorRole, $manageTags);
    
    
    $adminRole = $auth->createRole('admin');
    $auth->add($adminRole);
    
    $auth->addChild($adminRole, $moderatorRole);
    $auth->addChild($adminRole, $deleteUser);
    $auth->addChild($adminRole, $updateUser);
      
    //Defining the permission of whether the user can update commentary
    $auth->addChild($editOwnComments, $editComments);
    $auth->addChild($userRole, $editOwnComments);

    // Create admin 

    // It is supposed that after creation of admin the password would be changed
    // or admin rights would be passed to other user(s). 
    $user = new User([
        'id' => '1',
        'username' => 'Admin',
        'email' => 'admin@admin.com',
        'password' => '$2y$13$P9.d7KUb8C6BHCvkdzMsrOi5U.vIAw01UmriB.34PiN50e8nTGFge', // 111111
        'isAdmin' => '1',
    ]);
    $user->generateAuthKey();
    $user->save();
    
    // Assign admin role to 
    $auth->assign($adminRole, $user->getId());
  }

  /**
   * {@inheritdoc} 
   */
  public function safeDown()
  {
    $auth = Yii::$app->authManager;
    $auth->removeAll();
    $user = User::findOne(1);
    if($user){
      $user->delete();
    }
  }

}
