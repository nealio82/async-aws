<?php

namespace AsyncAws\MediaConvert\ValueObject;

/**
 * Group of outputs.
 */
final class OutputGroup
{
    /**
     * Use automated encoding to have MediaConvert choose your encoding settings for you, based on characteristics of your
     * input video.
     */
    private $automatedEncodingSettings;

    /**
     * Use Custom Group Name (CustomName) to specify a name for the output group. This value is displayed on the console and
     * can make your job settings JSON more human-readable. It does not affect your outputs. Use up to twelve characters
     * that are either letters, numbers, spaces, or underscores.
     */
    private $customName;

    /**
     * Name of the output group.
     */
    private $name;

    /**
     * Output Group settings, including type.
     */
    private $outputGroupSettings;

    /**
     * This object holds groups of encoding settings, one group of settings per output.
     */
    private $outputs;

    /**
     * @param array{
     *   AutomatedEncodingSettings?: null|AutomatedEncodingSettings|array,
     *   CustomName?: null|string,
     *   Name?: null|string,
     *   OutputGroupSettings?: null|OutputGroupSettings|array,
     *   Outputs?: null|Output[],
     * } $input
     */
    public function __construct(array $input)
    {
        $this->automatedEncodingSettings = isset($input['AutomatedEncodingSettings']) ? AutomatedEncodingSettings::create($input['AutomatedEncodingSettings']) : null;
        $this->customName = $input['CustomName'] ?? null;
        $this->name = $input['Name'] ?? null;
        $this->outputGroupSettings = isset($input['OutputGroupSettings']) ? OutputGroupSettings::create($input['OutputGroupSettings']) : null;
        $this->outputs = isset($input['Outputs']) ? array_map([Output::class, 'create'], $input['Outputs']) : null;
    }

    public static function create($input): self
    {
        return $input instanceof self ? $input : new self($input);
    }

    public function getAutomatedEncodingSettings(): ?AutomatedEncodingSettings
    {
        return $this->automatedEncodingSettings;
    }

    public function getCustomName(): ?string
    {
        return $this->customName;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getOutputGroupSettings(): ?OutputGroupSettings
    {
        return $this->outputGroupSettings;
    }

    /**
     * @return Output[]
     */
    public function getOutputs(): array
    {
        return $this->outputs ?? [];
    }

    /**
     * @internal
     */
    public function requestBody(): array
    {
        $payload = [];
        if (null !== $v = $this->automatedEncodingSettings) {
            $payload['automatedEncodingSettings'] = $v->requestBody();
        }
        if (null !== $v = $this->customName) {
            $payload['customName'] = $v;
        }
        if (null !== $v = $this->name) {
            $payload['name'] = $v;
        }
        if (null !== $v = $this->outputGroupSettings) {
            $payload['outputGroupSettings'] = $v->requestBody();
        }
        if (null !== $v = $this->outputs) {
            $index = -1;
            $payload['outputs'] = [];
            foreach ($v as $listValue) {
                ++$index;
                $payload['outputs'][$index] = $listValue->requestBody();
            }
        }

        return $payload;
    }
}
