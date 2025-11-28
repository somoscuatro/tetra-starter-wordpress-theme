#!/bin/bash

# Fetch the latest tags from the remote repository
git fetch --tags

# Get the latest version from the .version file
new_version=$(<.github/.version)

# Get the latest tag before the new version
previous_tag=$(git describe --tags --abbrev=0 $(git rev-list --tags --max-count=1))

# Generate the release notes content
echo "**CHANGELOG:**" >.github/.release-notes
echo "" >>.github/.release-notes
echo "- https://github.com/somoscuatro/tetra-starter-wordpress-theme/compare/${previous_tag}...${new_version}" >>.github/.release-notes
