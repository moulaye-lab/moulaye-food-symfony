*/
final class BeforeEntityDeletedEvent
{
    use StoppableEventTrait;

    private $entityInstance;

    public function __construct($entityInstance)
    {
        $this->entityInstance = $entityInstance;
    }
    public function getEntityInstance()
    {
        return $this->entityInstance;
    }
}