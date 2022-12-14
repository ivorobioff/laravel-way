<?php
namespace RealEstate\Core\Appraisal\Persistables;
use RealEstate\Core\Invitation\Persistables\InvitationPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreateOrderPersistable extends AbstractOrderPersistable
{
	/**
	 * @var AdditionalDocumentPersistable
	 */
	private $contractDocument;
	public function setContractDocument(AdditionalDocumentPersistable $document) { $this->contractDocument = $document; }
	public function getContractDocument() { return $this->contractDocument; }

    /**
     * @var InvitationPersistable
     */
    private $invitation;
    public function setInvitation(InvitationPersistable $persistable) { $this->invitation = $persistable; }
    public function getInvitation() { return $this->invitation; }

    /**
     * @var bool
     */
    private $isBidRequest;
    public function setBidRequest($flag) { $this->isBidRequest = $flag; }
    public function isBidRequest() { return $this->isBidRequest; }
}