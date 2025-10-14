#!/usr/bin/env bash
# Simple visual diff script
# Captures screenshots of two URLs at multiple viewports and compares them with ImageMagick.
# Requirements:
#  - Google Chrome or Chromium (chromium-browser or google-chrome) available in PATH
#  - ImageMagick (compare) installed
#  - Optional: lighthouse (npm) for audits: npm i -g lighthouse
#
# Usage:
# ./tools/visual-diff.sh <prod-url> <local-url>
# Example:
# ./tools/visual-diff.sh https://slackware-es.com http://localhost:8080/wordpress

set -euo pipefail

PROD_URL=${1:-}
LOCAL_URL=${2:-}
OUTDIR=${3:-visual-diff-output}
CHROME_BIN=${CHROME_BIN:-}
# Prefer brave if available, then chrome, then chromium
if [ -z "$CHROME_BIN" ]; then
  if [ -x "/usr/bin/brave-browser" ]; then
    CHROME_BIN="/usr/bin/brave-browser"
  else
    CHROME_BIN=$(which google-chrome || which chromium-browser || true)
  fi
fi

if [ -z "$PROD_URL" ] || [ -z "$LOCAL_URL" ]; then
  echo "Usage: $0 <prod-url> <local-url> [outdir]"
  exit 2
fi

if [ -z "$CHROME_BIN" ]; then
  echo "Chrome/Chromium binary not found. Set CHROME_BIN or install google-chrome/chromium-browser." >&2
  exit 3
fi

mkdir -p "$OUTDIR"

VIEWPORTS=("1366x768" "1024x768" "375x812")

echo "Using Chrome: $CHROME_BIN"

for vp in "${VIEWPORTS[@]}"; do
  W=${vp%x*}
  H=${vp#*x}
  PROD_PNG="$OUTDIR/prod_${vp}.png"
  LOCAL_PNG="$OUTDIR/local_${vp}.png"
  DIFF_PNG="$OUTDIR/diff_${vp}.png"

  echo "Capturing PROD $PROD_URL at $vp -> $PROD_PNG"
  "$CHROME_BIN" --headless --disable-gpu --window-size=$W,$H --screenshot="$PROD_PNG" "$PROD_URL"

  echo "Capturing LOCAL $LOCAL_URL at $vp -> $LOCAL_PNG"
  "$CHROME_BIN" --headless --disable-gpu --window-size=$W,$H --screenshot="$LOCAL_PNG" "$LOCAL_URL"

  echo "Comparing -> $DIFF_PNG"
  # Using ImageMagick compare; metric prints number of different pixels
  if command -v compare >/dev/null 2>&1; then
    compare -metric AE "$PROD_PNG" "$LOCAL_PNG" "$DIFF_PNG" 2> "$OUTDIR/metric_${vp}.txt" || true
    echo "Metric saved to $OUTDIR/metric_${vp}.txt"
  else
    echo "ImageMagick 'compare' not found; skipping image diff. Install imagemagick." >&2
  fi
done

# Optional: Lighthouse reports (uncomment to run)
# echo "Running Lighthouse on production..."
# lighthouse "$PROD_URL" --output html --output-path "$OUTDIR/lh_prod.html" --chrome-flags="--headless"
# echo "Running Lighthouse on local..."
# lighthouse "$LOCAL_URL" --output html --output-path "$OUTDIR/lh_local.html" --chrome-flags="--headless"

echo "Done. Open $OUTDIR to inspect screenshots and diffs."