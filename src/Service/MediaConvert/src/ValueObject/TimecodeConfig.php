<?php

namespace AsyncAws\MediaConvert\ValueObject;

use AsyncAws\Core\Exception\InvalidArgument;
use AsyncAws\MediaConvert\Enum\TimecodeSource;

/**
 * These settings control how the service handles timecodes throughout the job. These settings don't affect input
 * clipping.
 */
final class TimecodeConfig
{
    /**
     * If you use an editing platform that relies on an anchor timecode, use Anchor Timecode (Anchor) to specify a timecode
     * that will match the input video frame to the output video frame. Use 24-hour format with frame number, (HH:MM:SS:FF)
     * or (HH:MM:SS;FF). This setting ignores frame rate conversion. System behavior for Anchor Timecode varies depending on
     * your setting for Source (TimecodeSource). * If Source (TimecodeSource) is set to Specified Start (SPECIFIEDSTART),
     * the first input frame is the specified value in Start Timecode (Start). Anchor Timecode (Anchor) and Start Timecode
     * (Start) are used calculate output timecode. * If Source (TimecodeSource) is set to Start at 0 (ZEROBASED) the first
     * frame is 00:00:00:00. * If Source (TimecodeSource) is set to Embedded (EMBEDDED), the first frame is the timecode
     * value on the first input frame of the input.
     */
    private $anchor;

    /**
     * Use Source (TimecodeSource) to set how timecodes are handled within this job. To make sure that your video, audio,
     * captions, and markers are synchronized and that time-based features, such as image inserter, work correctly, choose
     * the Timecode source option that matches your assets. All timecodes are in a 24-hour format with frame number
     * (HH:MM:SS:FF). * Embedded (EMBEDDED) - Use the timecode that is in the input video. If no embedded timecode is in the
     * source, the service will use Start at 0 (ZEROBASED) instead. * Start at 0 (ZEROBASED) - Set the timecode of the
     * initial frame to 00:00:00:00. * Specified Start (SPECIFIEDSTART) - Set the timecode of the initial frame to a value
     * other than zero. You use Start timecode (Start) to provide this value.
     */
    private $source;

    /**
     * Only use when you set Source (TimecodeSource) to Specified start (SPECIFIEDSTART). Use Start timecode (Start) to
     * specify the timecode for the initial frame. Use 24-hour format with frame number, (HH:MM:SS:FF) or (HH:MM:SS;FF).
     */
    private $start;

    /**
     * Only applies to outputs that support program-date-time stamp. Use Timestamp offset (TimestampOffset) to overwrite the
     * timecode date without affecting the time and frame number. Provide the new date as a string in the format
     * "yyyy-mm-dd". To use Time stamp offset, you must also enable Insert program-date-time (InsertProgramDateTime) in the
     * output settings. For example, if the date part of your timecodes is 2002-1-25 and you want to change it to one year
     * later, set Timestamp offset (TimestampOffset) to 2003-1-25.
     */
    private $timestampOffset;

    /**
     * @param array{
     *   Anchor?: null|string,
     *   Source?: null|TimecodeSource::*,
     *   Start?: null|string,
     *   TimestampOffset?: null|string,
     * } $input
     */
    public function __construct(array $input)
    {
        $this->anchor = $input['Anchor'] ?? null;
        $this->source = $input['Source'] ?? null;
        $this->start = $input['Start'] ?? null;
        $this->timestampOffset = $input['TimestampOffset'] ?? null;
    }

    public static function create($input): self
    {
        return $input instanceof self ? $input : new self($input);
    }

    public function getAnchor(): ?string
    {
        return $this->anchor;
    }

    /**
     * @return TimecodeSource::*|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    public function getStart(): ?string
    {
        return $this->start;
    }

    public function getTimestampOffset(): ?string
    {
        return $this->timestampOffset;
    }

    /**
     * @internal
     */
    public function requestBody(): array
    {
        $payload = [];
        if (null !== $v = $this->anchor) {
            $payload['anchor'] = $v;
        }
        if (null !== $v = $this->source) {
            if (!TimecodeSource::exists($v)) {
                throw new InvalidArgument(sprintf('Invalid parameter "source" for "%s". The value "%s" is not a valid "TimecodeSource".', __CLASS__, $v));
            }
            $payload['source'] = $v;
        }
        if (null !== $v = $this->start) {
            $payload['start'] = $v;
        }
        if (null !== $v = $this->timestampOffset) {
            $payload['timestampOffset'] = $v;
        }

        return $payload;
    }
}
