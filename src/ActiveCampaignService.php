<?php

namespace Gentor\ActiveCampaign;


use ActiveCampaign;

/**
 * Class ActiveCampaignService
 *
 * @package Gentor\ActiveCampaign
 */
class ActiveCampaignService
{
    /**
     * @var \ActiveCampaign
     */
    public $ac;

    /**
     * IntercomService constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->ac = new ActiveCampaign($config['api_url'], $config['api_key']);
    }

    /**
     * @return mixed
     */
    public function accountView()
    {
        return $this->ac->api("account/view");
    }

    /**
     * @param $id
     *
     * @return \stdClass|null
     */
    public function contactView($id)
    {
        return $this->returnNullIfNotFound($this->ac->api("contact/view?id={$id}"));
    }

    /**
     * @param $email
     *
     * @return \stdClass|null
     */
    public function contactViewByEmail($email)
    {
        return $this->returnNullIfNotFound($this->ac->api("contact/view?email={$email}"));
    }

    /**
     * @param $hash
     *
     * @return \stdClass|null
     */
    public function contactViewByHash($hash)
    {
        return $this->returnNullIfNotFound($this->ac->api("contact/view?hash={$hash}"));
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function contactSync(array $data)
    {
        $result = $this->ac->api("contact/sync", $data);
        return (bool)$result->success;
    }

    /**
     * @param \stdClass $contact
     * @param array     $new_lists_ids
     *
     * @return bool
     */
    public function contactChangeLists(\stdClass $contact, array $new_lists_ids)
    {
        $old_lists = $new_lists = [];

        foreach ($contact->lists as $list) {
            $old_lists["p[{$list->listid}]"] = $list->listid;
            $old_lists["status[{$list->listid}]"] = 2; // 2 = unsubscribed
        }

        foreach ($new_lists_ids as $new_lists_id) {
            $new_lists["p[{$new_lists_id}]"] = $new_lists_id;
            $new_lists["status[{$new_lists_id}]"] = 1; // 1 = active
        }

        $lists = array_merge($old_lists, $new_lists);
        $lists['email'] = $contact->email;

        return $this->contactSync($lists);
    }

    /**
     * @param $response
     *
     * @return \stdClass|null
     */
    protected function returnNullIfNotFound($response)
    {
        if (empty($response->success)) {
            return null;
        }

        return $response;
    }

}