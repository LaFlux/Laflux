<?php
namespace ExtensionsValley\Dashboard\Models\traits;

trait DashboardTraits
{

    function getNavigationBar()
    {

        $this->getRecentMessages();
        $this->getRecentTasks();
        $this->getRecentRemainders();
        $this->getProfileLink();
    }

    function getRecentMessages()
    {

    }

    function getRecentTasks()
    {

    }

    function getRecentRemainders()
    {

    }

    function getProfileLink()
    {

    }

    function getWidgets()
    {

    }

}
