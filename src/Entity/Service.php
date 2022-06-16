<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(formats={"json"},
 *     forceEager=false,
 *     normalizationContext={"groups"={"service:read"},"enable_max_depth"=true},
 *     denormalizationContext={"groups"={"service:write"},"enable_max_depth"=true})
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 * @ApiFilter(SearchFilter::class, properties={"title": "ipartial","speciality.name": "ipartial",
 *     "firstName": "ipartial","lastName": "ipartial"})
 */
class Service extends User
{

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"service:read","service:write","speciality:read"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     *  @Groups({"service:read","service:write","speciality:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="array")
     *  @Groups({"service:read","service:write","speciality:read"})
     */
    private $languages = [];

    /**
     * @ORM\Column(type="array")
     *  @Groups({"service:read","service:write","speciality:read"})
     */
    private $paymentMethods = [];


    /**
     * @ORM\OneToMany(targetEntity=TimeSheet::class, mappedBy="service", orphanRemoval=true)
     *  @Groups({"service:read","service:write","speciality:read"})
     */
    private $timeSheets;

    /**
     * @ORM\OneToMany(targetEntity=Feedback::class, mappedBy="service")
     *  @Groups({"service:read","service:write","speciality:read"})
     */
    private $feedbacks;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="service", orphanRemoval=true)
     *  @Groups({"service:read","service:write","speciality:read"})
     */
    private $appointments;

    /**
     * @ORM\ManyToMany(targetEntity=Insurance::class, inversedBy="services")
     *  @Groups({"service:read","service:write","speciality:read"})
     */
    private $insurance;


    /**
     * @ORM\ManyToOne(targetEntity=Speciality::class, inversedBy="services")
     * @Groups({"service:read","service:write"})
     */
    private $speciality;

    public function __construct()
    {
        $this->timeSheets = new ArrayCollection();
        $this->feedbacks = new ArrayCollection();
        $this->appointments = new ArrayCollection();
        $this->insurance = new ArrayCollection();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLanguages(): ?array
    {
        return $this->languages;
    }

    public function setLanguages(array $languages): self
    {
        $this->languages = $languages;

        return $this;
    }

    public function getPaymentMethods(): ?array
    {
        return $this->paymentMethods;
    }

    public function setPaymentMethods(array $paymentMethods): self
    {
        $this->paymentMethods = $paymentMethods;

        return $this;
    }

   

    /**
     * @return Collection<int, TimeSheet>
     */
    public function getTimeSheets(): Collection
    {
        return $this->timeSheets;
    }

    public function addTimeSheet(TimeSheet $timeSheet): self
    {
        if (!$this->timeSheets->contains($timeSheet)) {
            $this->timeSheets[] = $timeSheet;
            $timeSheet->setService($this);
        }

        return $this;
    }

    public function removeTimeSheet(TimeSheet $timeSheet): self
    {
        if ($this->timeSheets->removeElement($timeSheet)) {
            // set the owning side to null (unless already changed)
            if ($timeSheet->getService() === $this) {
                $timeSheet->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Feedback>
     */
    public function getFeedbacks(): Collection
    {
        return $this->feedbacks;
    }

    public function addFeedback(Feedback $feedback): self
    {
        if (!$this->feedbacks->contains($feedback)) {
            $this->feedbacks[] = $feedback;
            $feedback->setService($this);
        }

        return $this;
    }

    public function removeFeedback(Feedback $feedback): self
    {
        if ($this->feedbacks->removeElement($feedback)) {
            // set the owning side to null (unless already changed)
            if ($feedback->getService() === $this) {
                $feedback->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Appointment>
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->setService($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getService() === $this) {
                $appointment->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Insurance>
     */
    public function getInsurance(): Collection
    {
        return $this->insurance;
    }

    public function addInsurance(Insurance $insurance): self
    {
        if (!$this->insurance->contains($insurance)) {
            $this->insurance[] = $insurance;
        }

        return $this;
    }

    public function removeInsurance(Insurance $insurance): self
    {
        $this->insurance->removeElement($insurance);

        return $this;
    }

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(?Speciality $speciality): self
    {
        $this->speciality = $speciality;

        return $this;
    }


}
