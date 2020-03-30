<?php
/**
 * SiteExtension
 *
 * Provides an interface to run an Extension after instantiating.
 *
 * @package launchpad
 * @since 1.0.0
 */

namespace CORE\Extensions;

interface SiteExtension {
    public function extend();
}
