<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-9-18
 * Time: 11:04am
 */

class RbacCommand extends CConsoleCommand
{
    private $_authManager;

    public function getHelp()
    {
        return <<<EOD
USAGE
  rbac
DESCRIPTION
  This command generates an initial RBAC authorization hierarchy.
EOD;
    }

    /**
     * Execute the action.
     * @param array command line parameters specific for this command
     */
    public function run($args)
    {
        //ensure that an authManager is defined as this is mandatory for creating an auth heirarchy
        if(($this->_authManager=Yii::app()->authManager)===null)
        {
            echo "Error: an authorization manager, named 'authManager' must be configured to use this command.\n";
            echo "If you already added 'authManager' component in application configuration,\n";
            echo "please quit and re-enter the yiic shell.\n";
            return;
        }

        //provide the oportunity for the use to abort the request
        echo "This command will create three roles: Owner, Member, and Reader and the following premissions:\n";
        echo "create, read, update and delete user\n"; echo "create, read, update and delete project\n";
        echo "create, read, update and delete issue\n"; echo "Would you like to continue? [Yes|No] ";

        //check the input from the user and continue if they indicated yes to the above question
        if(!strncasecmp(trim(fgets(STDIN)),'y',1))
        {
            //first we need to remove all operations, roles, child relationship and assignments
            $this->_authManager->clearAll();

            //create the lowest level operations for users
            $this->_authManager->createOperation("createUser","create a new user");
            $this->_authManager->createOperation("readUser","read user profile information");
            $this->_authManager->createOperation("updateUser","update a user's information");
            $this->_authManager->createOperation("deleteUser","remove a user");
            $this->_authManager->createOperation("listUser","list users");

            //create the lowest level operations for company
            $this->_authManager->createOperation("createCompany","create a new Company");
            $this->_authManager->createOperation("readCompany","read Company information");
            $this->_authManager->createOperation("updateCompany","update Company information");
            $this->_authManager->createOperation("deleteCompany","delete a Company");
            $this->_authManager->createOperation("listCompany","list Companies");

            //create the lowest level operations for store
            $this->_authManager->createOperation("createStore","create a new Store");
            $this->_authManager->createOperation("readStore","read Store information");
            $this->_authManager->createOperation("updateStore","update Store information");
            $this->_authManager->createOperation("deleteStore","delete a Store");
            $this->_authManager->createOperation("listStore","list Stores");

            //create the reader role and add the appropriate permissions as children to this role
            $role=$this->_authManager->createRole("visitor");

            //create the member role, and add the appropriate permissions, as well as the reader role itself, as children
            $role=$this->_authManager->createRole("operator"); $role->addChild("visitor");

            //create the owner role, and add the appropriate permissions, as well as both the reader and member roles as children
            $role=$this->_authManager->createRole("manager");
            $role->addChild("visitor");
            $role->addChild("operator");
            $role->addChild("readUser");
            $role->addChild("createUser");
            $role->addChild("updateUser");
            $role->addChild("deleteUser");
            $role->addChild("listUser");
            $role->addChild("readCompany");
            $role->addChild("createCompany");
            $role->addChild("updateCompany");
            $role->addChild("deleteCompany");
            $role->addChild("listCompany");
            $role->addChild("readStore");
            $role->addChild("createStore");
            $role->addChild("updateStore");
            $role->addChild("deleteStore");
            $role->addChild("listStore");

            //provide a message indicating success
            echo "Authorization hierarchy successfully generated.";
        }
    }
}