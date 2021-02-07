<?php

namespace CedricZiel\CanvaBundle\Model;

trait CanvaRecognized
{
    public function getCanvaId(): ?string
    {
        return $this->canvaId;
    }

    public function setCanvaId(?string $canvaId): self
    {
        $this->canvaId = $canvaId;

        return $this;
    }
}
