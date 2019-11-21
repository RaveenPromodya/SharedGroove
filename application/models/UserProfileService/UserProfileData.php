<?php
include('User.php');
class UserProfileData extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getUserProfileData($userId)
    {
        return $this->getUserDetails($userId);

    }

    public function getUserDetails($userId)
    {
        $this->db->select('*');
        $this->db->from('User');
        $this->db->where('userId', $userId);
        $query = $this->db->get();

        $user = new User();
        $user->setUserId($query->row_array()['userId']);
        $user->setFirstName($query->row_array()['firstName']);
        $user->setLastName($query->row_array()['lastName']);
        $user->setEmail($query->row_array()['email']);
        $user->setProfilePicture($query->row_array()['profilePicture']);

        return $this->getUserFollowerCount($user);
    }

    public function getUserFollowerCount($user)
    {
        $this->db->select('*');
        $this->db->from('UserFollowing');
        $this->db->where('followingUser', $user->getEmail());
        $query = $this->db->get();

        $user->setFollowerCount($query->num_rows());

        return $this->getUserFollowingCount($user);
    }

    public function getUserFollowingCount($user)
    {
        $this->db->select('*');
        $this->db->from('UserFollowing');
        $this->db->where('mainUser', $user->getEmail());
        $query = $this->db->get();
        $user->setFollowingCount($query->num_rows());

        return $this->getUserGenres($user);
    }

    public function getUserGenres($user)
    {
        $this->db->select('genreType');
        $this->db->from('UserGenre');
        $this->db->where('userEmail', $user->getEmail());
        $query = $this->db->get();

        $userGenres = array();

        foreach ($query->result() as $genre) {
            array_push($userGenres, $genre->genreType);
        }

        $user->setUserGenres($userGenres);

        return $this->isMainUserFollowing($user);
    }

    public function isMainUserFollowing($user) {
        $this->db->select('*');
        $this->db->from('UserFollowing');
        $condition = array(
            'mainUser'=>$this->session->userdata('email'),
            'followingUser'=>$user->getEmail(),
        );
        $this->db->where($condition);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $user->setIsFollowing(true);
        }

        return $this->getFollowersEmails($user);
    }

    //Friends Count - Start
    public function getFollowersEmails($user)
    {
        $followerEmails = array();
        $this->db->select('mainUser');
        $this->db->from('UserFollowing');
        $this->db->where('followingUser', $user->getEmail());
        $query = $this->db->get();

        foreach ($query->result() as $follower) {
            array_push($followerEmails, $follower->mainUser);
        }

        return $this->getFollowingEmails($user, $followerEmails);
    }

    public function getFollowingEmails($user, $followerEmails)
    {
        $followingEmails = array();
        $this->db->select('followingUser');
        $this->db->from('UserFollowing');
        $this->db->where('mainUser', $user->getEmail());
        $query = $this->db->get();

        foreach ($query->result() as $following) {
            array_push($followingEmails, $following->followingUser);
        }

        return $this->getTheFriends($user, $followerEmails, $followingEmails);
    }

    public function getTheFriends($user, $followerEmails, $followingEmails)
    {
        $friendsEmails = array();
        for ($x = 0; $x < sizeof($followerEmails); $x++) {
            for ($y = 0; $y < sizeof($followingEmails); $y++) {
                if ($followerEmails[$x] == $followingEmails[$y]) {
                    array_push($friendsEmails, $followingEmails[$y]);
                }
            }
        }

        $user->setFriendCount(sizeof($friendsEmails));

        return $this->configReturnObject($user);
    }
    //End

    public function configReturnObject($user)
    {
        $returnArray = array(
            'userId' => $user->getUserId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
            'profilePicture' => $user->getProfilePicture(),
            'followerCount' => $user->getFollowerCount(),
            'followingCount' => $user->getFollowingCount(),
            'userGenres' => $user->getUserGenres(),
            'friendsCount'=>$user->getFriendCount(),
            'isFollowing'=>$user->getIsFollowing(),
        );

        return $returnArray;
        // var_dump($returnArray);
    }
}
