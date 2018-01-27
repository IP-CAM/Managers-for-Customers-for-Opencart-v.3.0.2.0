<?php

class ControllerExtensionModuleManagersForCustomers extends Controller
{
    public function index()
    {
        $data['managers']  = [];
        $customer_group_id = $this->customer->getGroupId();
        $user_group_id     = null;

        $this->load->model('extension/module/managersforcustomers');

        $user_groups = $this->cache->get('managersforcustomers_usergroups');

        if (empty($user_groups)) {
            $user_groups = $this->model_extension_module_managersforcustomers->getUserGroups();
            $this->cache->set('managersforcustomers_usergroups', $user_groups);
        }

        if ( ! is_array($user_groups)) {
            return $this->load->view('extension/module/managersforcustomers', $data);
        }

        foreach ($user_groups as $group) {
            if (in_array($customer_group_id, json_decode($group['customer_groups']))) {
                $user_group_id = (int)$group['user_group_id'];
                continue;
            }
        }

        if (null === $user_group_id) {
            return $this->load->view('extension/module/managersforcustomers', $data);
        }

        $managers = $this->cache->get('managersforcustomers_users' . $user_group_id);

        if (empty($managers)) {
            $managers = $this->model_extension_module_managersforcustomers->getUsersByGroup($user_group_id);
            $this->cache->set('managersforcustomers_users' . $user_group_id, $managers);
        }

        $data['managers'] = $managers;

        return $this->load->view('extension/module/managersforcustomers', $data);
    }
}
