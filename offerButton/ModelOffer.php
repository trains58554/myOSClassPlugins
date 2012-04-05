<?php
    /*
     *      OSCLass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2010 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    /**
     * Model database for Offer Button tables
     * 
     * @package OSClass
     * @subpackage Model
     * @1.0
     */
    class ModelOffer extends DAO
    {
        /**
         * It references to self object: ModelOffer.
         * It is used as a singleton
         * 
         * @access private
         * @1.0
         * @var ModelOffer
         */
        private static $instance ;

        /**
         * It creates a new ModelOffer object class if it has been created
         * before, it return the previous object
         * 
         * @access public
         * @1.0
         * @return ModelOffer
         */
        public static function newInstance()
        {
            if( !self::$instance instanceof self ) {
                self::$instance = new self ;
            }
            return self::$instance ;
        }

        /**
         * Construct
         */
        function __construct()
        {
            parent::__construct();
        }
        
        /**
         * Return table name offer_button
         * @return string
         */
        public function getTable_offer_button()
        {
            return DB_TABLE_PREFIX.'t_offer_button';
        }
        
        /**
         * Return table name offer_item_options
         * @return string
         */
        public function getTable_offer_item()
        {
            return DB_TABLE_PREFIX.'t_offer_item_options';
        }
        
        /**
         * Return table name offer_reason
         * @return string
         */
        public function getTable_offer_reason()
        {
            return DB_TABLE_PREFIX.'t_offer_reason';
        }
        
        /**
         * Return table name offer_user_locked
         * @return string
         */
        public function getTable_offer_user_locked()
        {
            return DB_TABLE_PREFIX.'t_offer_user_locked';
        }
                
        /**
         * Return table name t_users
         * @return string
         */
        public function getTable_users()
        {
            return DB_TABLE_PREFIX.'t_user';
        }
              
        /**
         * Import sql file
         * @param type $file 
         */
        public function import($file)
        {
            $path = osc_plugin_resource($file) ;
            $sql = file_get_contents($path);

            if(! $this->dao->importSQL($sql) ){
                throw new Exception( "Error importSQL::ModelOffer<br>".$file ) ;
            }
        }
                
        /**
         * Remove data and tables related to the plugin.
         */
        public function uninstall()
        {
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_offer_button()) ) ;
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_offer_item()) ) ;  
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_offer_reason()) ) ;
            $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_offer_user_locked()) ) ;
        }
        
        /** 
         * Adds email templstes.
         *
         *
         */
        public function insertEmailTemplates() {
            //used for email template
            $this->dao->insert(DB_TABLE_PREFIX.'t_pages', array('s_internal_name' => 'email_new_offer', 'b_indelible' => 1, 'dt_pub_date' => date('Ydm')));
            $this->dao->insert(DB_TABLE_PREFIX.'t_pages', array('s_internal_name' => 'email_offer_status', 'b_indelible' => 1, 'dt_pub_date' => date('Ydm')));
            
            $this->dao->select();
            $this->dao->from( DB_TABLE_PREFIX.'t_pages' );
            $this->dao->where('s_internal_name', 'email_new_offer');

            $result = $this->dao->get();
            $pageInfo = $result->row();
            
            $this->dao->select();
            $this->dao->from( DB_TABLE_PREFIX.'t_pages' );
            $this->dao->where('s_internal_name', 'email_offer_status');

            $result = $this->dao->get();
            $pageInfo1 = $result->row();
            
            foreach(osc_listLanguageCodes() as $locales) {
               $this->dao->insert(DB_TABLE_PREFIX.'t_pages_description', array('fk_i_pages_id' => $pageInfo['pk_i_id'], 'fk_c_locale_code' => $locales, 's_title' => '{WEB_TITLE} - New offer on: {ITEM_TITLE}', 's_text' => "<p>Hi {CONTACT_NAME}!</p>\r\n<p> </p>\r\n<p>You just got a new offer of \${OFFER_VALUE} on your item {ITEM_TITLE} on {WEB_TITLE}.</p>\r\n<p>Click on the link to view the new offer {OFFER_URL}</p><p> </p>\r\n<p>This is an automatic email, if you have already seen this offer, please ignore this email.</p>\r\n<p> </p>\r\n<p>Thanks</p>"));
               $this->dao->insert(DB_TABLE_PREFIX.'t_pages_description', array('fk_i_pages_id' => $pageInfo1['pk_i_id'], 'fk_c_locale_code' => $locales, 's_title' => '{WEB_TITLE} - Offer status updated on: {ITEM_TITLE}', 's_text' => "<p>Hi {CONTACT_NAME}!</p>\r\n<p> </p>\r\n<p>Your offer on {ITEM_TITLE} {OFFER_STATUS} on {WEB_TITLE}.</p>\r\n<p>Click on the link to view the staus of your offer {OFFER_STATUS_URL}</p><p> </p>\r\n<p>This is an automatic email, if you have already seen this offer, please ignore this email.</p>\r\n<p> </p>\r\n<p>Thanks</p>"));
            }
        }
        
        /**
         * Remove Email Templates
         *
         *
         */
        public function removeEmailTemplates() {
            $this->dao->select();
            $this->dao->from( DB_TABLE_PREFIX.'t_pages' );
            $this->dao->where('s_internal_name', 'email_new_offer');

            $result = $this->dao->get();
            $pageInfo = $result->row();
            
            $this->dao->select();
            $this->dao->from( DB_TABLE_PREFIX.'t_pages' );
            $this->dao->where('s_internal_name', 'email_offer_status');

            $result = $this->dao->get();
            $pageInfo1 = $result->row();
            
            $this->dao->delete( DB_TABLE_PREFIX.'t_pages_description', array('fk_i_pages_id' => $pageInfo['pk_i_id']));
            $this->dao->delete( DB_TABLE_PREFIX.'t_pages_description', array('fk_i_pages_id' => $pageInfo1['pk_i_id']));
            $this->dao->delete( DB_TABLE_PREFIX.'t_pages', array('pk_i_id' => $pageInfo['pk_i_id']));
            $this->dao->delete( DB_TABLE_PREFIX.'t_pages', array('pk_i_id' => $pageInfo1['pk_i_id']));
        }
        
        /**
         * Get users
         *
         * @return array 
         */
        public function getUsers()
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_users());
            $this->dao->where('b_enabled', 1);
            $this->dao->where('b_active', 1);

            $result = $this->dao->get();
            return $result->result();
        }
        
        /**
         * Get offers
         *
         * @param int $where, $del, $limit
         * @param string $whereKey, $orderBy, $oDir
         * @return array 
         */
        public function getOffers($whereKey, $where, $whereKey1=NULL, $where1=NULL, $del=NULL, $orderBy = null, $oDir = null, $limit = 3)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_offer_button());
            $this->dao->where($whereKey, $where);
            
            if(!$whereKey1 == NULL && !$where1 == NULL){
               $this->dao->where($whereKey1, $where1);
            }
            
            if($del == 1) {
               $this->dao->where('sDelete', 0);
            }
            
            if(!$orderBy == NULL && !$oDir == NULL) {
               $this->dao->orderBy($orderBy, $oDir);
            }
            
            if(!$limit == NULL){
               $this->dao->limit($limit);
            }

            $result = $this->dao->get();
            return $result->result();
        }
        
        /**
         * Get offer
         *
         * @param int $where, $del, $limit
         * @param string $whereKey, $orderBy, $oDir
         * @return array 
         */
        public function getOffer($whereKey, $where, $whereKey1 =NULL, $where1=NULL, $del=NULL, $orderBy = null, $oDir = null, $limit = 3)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_offer_button());
            $this->dao->where($whereKey, $where);
            
            if(!$whereKey1 == NULL && !$where1 == NULL){
               $this->dao->where($whereKey1, $where1);
            }
            
            if($del == 1) {
               $this->dao->where('sDelete', 0);
            }
            
            if(!$orderBy == NULL && !$oDir == NULL) {
               $this->dao->orderBy($orderBy, $oDir);
            }
            
            if(!$limit == NULL){
               $this->dao->limit($limit);
            }

            $result = $this->dao->get();
            if($result) {
               return $result->row();
            } else {
               return false;
            }
        }
        
        /**
         * Get offer item options
         *
         * @param int $itemId
         * @return array 
         */
        public function getOfferItemOption($itemId)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_offer_item());
            $this->dao->where('fk_i_item_id', $itemId);

            $result = $this->dao->get();
            return $result->row();
        }
        
        /**
         * Insert offer item options
         *
         * @param int $itemId, $bOffer, $bMonetary, $bTrade
         */
        public function insertOptions( $itemId, $bOffer = 0, $bMonetary = 0, $bTrade = 0)
        {
            $this->dao->insert($this->getTable_offer_item(), array('fk_i_item_id' => $itemId, 'b_offerYes' => $bOffer, 'b_offerMonetary' => $bMonetary, 'b_offerTrade' => $bTrade)) ;
        }
        
        /**
         * Replace offer item options
         *
         * @param int $itemId, $bOffer, $bMonetary, $bTrade
         */
        public function replaceOptions( $itemId, $bOffer = 0, $bMonetary = 0, $bTrade = 0)
        {
            $this->dao->replace($this->getTable_offer_item(), array('fk_i_item_id' => $itemId, 'b_offerYes' => $bOffer, 'b_offerMonetary' => $bMonetary, 'b_offerTrade' => $bTrade)) ;
        }
        
        /**
         * Delete offer button and offer item options if the item gets deleted
         *
         *
         */
        public function deleteOfferItem($itemId) 
        {
            $this->dao->delete( $this->getTable_offer_item(), array('fk_i_item_id' => $itemId));
            $this->dao->delete( $this->getTable_offer_button(), array('item_id' => $itemId));
        }
        
        /**
         * Update offer_button
         * 
         * @param int $sellerId
         */
        public function updateOfferNew($sellerId)
        {
            $this->_update( $this->getTable_offer_button(), array('oNew' => 0), array('seller_id' => $sellerId, 'oNew' => 1)) ;
        }
        
        /**
         * Get offer user locked
         *
         * @param int $sellerId, $userId
         * @return array 
         */
        public function getLockedStatus($sellerId, $whereKey = NULL, $where = NULL)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_offer_user_locked());
            $this->dao->where('seller_id', $sellerId);
            if($whereKey != NULL) {
               $this->dao->where($whereKey, $where);
            }

            $result = $this->dao->get();
            if($result){
               return $result->row();
            } else {
               return 0;
            }           
        }
        
        /**
         * Get offer user reason
         *
         * @param int $Id
         * @return array 
         */
        public function getReason($Id)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_offer_reason());
            $this->dao->where('seller_id', $Id);

            $result = $this->dao->get();
            return $result->row();
        }
        
        /**
         * Get offer reasons
         *
         * @param int $Id
         * @return array 
         */
        public function getReasons()
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_offer_reason());

            $result = $this->dao->get();
            return $result->result();
        }
        
        /**
         * Insert offer 
         *
         * @param int $itemId, $bOffer, $bMonetary, $bTrade
         */
        public function insertOffer( $userId, $b_email=NULL, $b_name=NULL, $sellerId, $itemId, $offerValue, $offerStatus, $offerType, $new)
        {             
            $this->dao->insert($this->getTable_offer_button(), array('user_id' => $userId, 'b_name' => $b_name, 'b_email' => $b_email, 'seller_id' => $sellerId, 'item_id' => $itemId, 'offer_value' => $offerValue, 'offer_status' => $offerStatus,'offer_type' => $offerType, 'oNew' => $new)) ;
        }
        
        /**
         * Update offer status
         * 
         * @param int $offerId, $status
         */
        public function updateOfferStatus($offerId, $status)
        {
            $this->_update( $this->getTable_offer_button(), array('offer_status' => $status), array('id' => $offerId)) ;
        }
        
        /**
         * Update offer deleted
         * 
         * @param int $offerId
         */
        public function updateDelete($offerId)
        {
            $this->_update( $this->getTable_offer_button(), array('sDelete' => 1), array('id' => $offerId)) ;
        }
        
        /**
         * Update offer locking
         * 
         * @param int $offerId
         */
        public function updateLocking($lock, $whereKey, $where)
        {
            $this->_update( $this->getTable_offer_button(), array('user_locked' => $lock), array($whereKey => $where)) ;
        }
        
        /**
         * replace user locked
         *
         * @param $sellerId, $key, $keyValue, $reason, $locked
         */
        public function replaceLocked($sellerId, $key, $keyValue, $reason, $locked)
        {       
           $this->dao->replace( $this->getTable_offer_user_locked(), array('seller_id' => $sellerId, $key => $keyValue, 'reason_code' => $reason, 'locked' => $locked));
        }
        
        /**
         * Update offer reasons
         * 
         * @param $reason, $offerId
         */
        public function updateReason($reason, $offerId)
        {
            $this->_update( $this->getTable_offer_reason(), array('reason' => $reason), array('id' => $offerId)) ;
        }
        
        /**
         * Insert offer reason
         * 
         * @param $reason
         */
        public function insertReason($reason)
        {
            $this->dao->insert( $this->getTable_offer_reason(), array('reason' => $reason)) ;
        }
        
        /**
         * Delete offer reason
         * 
         * @param $offerId
         */
        public function deleteReason($offerId)
        {
            $this->dao->delete( $this->getTable_offer_reason(), array('id' => $offerId)) ;
        }
        
/** use below as templates not actually for this plugin
         * Get by primary key
         *
         * @param int $pm_id
         * @return array 
         */
        public function getByPrimaryKey($pm_id, $del=NULL, $orderBy = null, $oDir = null)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_pmMessages());
            $this->dao->where('pm_id', $pm_id);
            if($del == 1) {
               $this->dao->where('senderDelete', 0);
               $this->dao->where('recipDelete', 0);
            }
            
            if(!$orderBy == NULL || !$oDir == NULL) {
               $this->dao->orderBy($orderBy, $oDir);
            }

            $result = $this->dao->get();
            return $result->row();
        }
        
        /**
         * Get Recipient Messages
         *
         * @param int $itemId
         * @return array 
         */
        public function getRecipientMessages($recipId, $del=NULL, $new=NULL, $orderBy = null, $oDir = null)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_pmMessages());
            $this->dao->where('recip_id', $recipId);
            if($del == 1) {
               $this->dao->where('recipDelete', 0);
            }
            
            if($new == 1) {
               $this->dao->where('recipNew', 1);
            }
            
            if(!$orderBy == NULL || !$oDir == NULL) {
               $this->dao->orderBy($orderBy, $oDir);
            }

            $result = $this->dao->get();
            return $result->result();
        }
        
        /**
         * Get Recipient Message
         *
         * @param int $itemId
         * @return array 
         */
        public function getRecipientMessage($recipId, $del=NULL, $new=NULL, $pm_id)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_pmMessages());
            $this->dao->where('recip_id', $recipId);
            if($del == 1) {
               $this->dao->where('recipDelete', 0);
            }
            
            if($new == 1) {
               $this->dao->where('recipNew', 1);
            }
            
            $this->dao->where('pm_id', $pm_id);

            $result = $this->dao->get();
            return $result->row();
        }
        
        /**
         * count Recipient Messages
         *
         * @param int $itemId
         * @return array 
         */
        public function countRecipientMessages($recipId, $del=NULL)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_pmMessages());
            $this->dao->where('recip_id', $recipId);
            if($del == 1) {
               $this->dao->where('recipDelete', 0);
            }
            

            $result = $this->dao->get();
            $aux = $result->result();
            $aux = count($aux);
            return $aux;
        }
        
        /**
         * Get Recipient Message
         *
         * @param int $itemId
         * @return array 
         */
        public function getSenderMessage($senderId, $del=NULL, $pm_id)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_pmMessages());
            $this->dao->where('sender_id', $senderId);
            if($del == 1) {
               $this->dao->where('senderDelete', 0);
            }
            
            $this->dao->where('pm_id', $pm_id);

            $result = $this->dao->get();
            return $result->row();
        }
        
        /**
         * Get Draft Messages
         *
         * @param int $itemId
         * @return array 
         */
        public function getDrafts($sendId, $orderBy = null, $oDir = null)
        {
            $this->dao->select();
            $this->dao->from( $this->getTable_pmDrafts());
            $this->dao->where('sender_id', $sendId);
            if(!$orderBy == NULL || !$oDir == NULL) {
               $this->dao->orderBy($orderBy, $oDir);
            }

            $result = $this->dao->get();
            return $result->result();
        }
        
        /**
         * Update recip delete by id
         * 
         * @param int $pm_id 
         */
        public function updateMessagesRecipDelete($pm_id)
        {
            $this->_update( $this->getTable_pmMessages(), array('recipDelete' => 1), array('pm_id' => $pm_id)) ;
        }
        
        /**
         * Update sender delete by id
         * 
         * @param int $pm_id 
         */
        public function updateMessagesSenderDelete($pm_id)
        {
            $this->_update( $this->getTable_pmMessages(), array('senderDelete' => 1), array('pm_id' => $pm_id)) ;
        }
        
        /**
         * Update message as read
         * 
         * @param int $pm_id 
         */
        public function updateMessageAsRead($pm_id)
        {
            $this->_update( $this->getTable_pmMessages(), array('recipNew' => 0), array('pm_id' => $pm_id)) ;
        }
        
        /**
         * Get user pm settings
         *
         * @param int $user_id
         */
        public function getUserPmSettings($user_id)
        {
           $this->dao->select();
           $this->dao->from( $this->getTable_pmSettings());
           $this->dao->where('fk_i_user_id', $user_id);

           $result = $this->dao->get();
           return $result->row();
        }
        
        /**
         * update user pm settings
         *
         * @param int $user_id, $emailAlert, $flashAlert, $saveSent
         */
        public function updatePmSettings($user_id, $emailAlert, $flashAlert, $saveSent)
        {
            $this->_update( $this->getTable_pmSettings(), array('send_email' => $emailAlert, 'flash_alert' => $flashAlert, 'save_sent' => $saveSent), array('fk_i_user_id' => $user_id)) ;
        }
        
        /**
         * Insert a Message
         *
         * @param int $sender_id, $recip_id, $senderDelete
         * @param string $pm_subject, pm_message
         */
        public function insertMessage( $sender_id, $recip_id, $pm_subject, $pm_message, $senderDelete = 1)
        {
            $this->dao->insert($this->getTable_pmMessages(), array('sender_id' => $sender_id, 'recip_id' => $recip_id, 'pm_subject' => $pm_subject, 'pm_message' => $pm_message, 'senderDelete' => $senderDelete)) ;
        }
        
        
        /**
         * Insert all users into pmsettings
         *
         * 
         */
        public function insertUsersPmSettings()
        {
            $userIds = $this->getUsers();
            foreach($userIds as $user_id) {
               $this->dao->insert($this->getTable_pmSettings(), array('fk_i_user_id' => $user_id['pk_i_id'], 'send_email' => 1, 'flash_alert' => '0', 'save_sent' => '0')) ;
            }
        }
        
        
        /**
         * Cron remove sender and recip messages if both are deleted.
         *
         *
         */
        public function deleteMessages() 
        {
            $this->dao->delete( $this->getTable_pmMessages(), array('senderDelete' => 1, 'recipDelete' => 1));
        }
               
        /**
         * Return last id inserted into cars vehicle type table
         * 
         * @return int 
         */
        public function getLastMessageId()
        {
            $this->dao->select('pm_id');
            $this->dao->from($this->getTable_pmMessages()) ;
            $this->dao->orderBy('pm_id', 'DESC') ;
            $this->dao->limit(1) ;
            
            $result = $this->dao->get() ;
            $aux = $result->row();
            return $aux['pm_id']; 
        }
        
        // update
        function _update($table, $values, $where)
        {
            $this->dao->from($table) ;
            $this->dao->set($values) ;
            $this->dao->where($where) ;
            return $this->dao->update() ;
        }
    }
?>
