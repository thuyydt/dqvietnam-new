#!/bin/bash

# Background Image Optimization
# Specifically optimizes the large bg-main.jpg file

set -e

IMAGE_DIR="apps/dqvietnam/public/game/list/images"
BG_IMAGE="$IMAGE_DIR/bg-main.jpg"
BG_JPEG="$IMAGE_DIR/bg-main.jpeg"

echo "========================================="
echo "Background Image Optimization"
echo "========================================="
echo ""

# Check if imagemagick is installed
if ! command -v magick &> /dev/null && ! command -v convert &> /dev/null; then
    echo "❌ Error: ImageMagick not installed"
    echo "Install with: brew install imagemagick"
    exit 1
fi

if command -v magick &> /dev/null; then
    MAGICK_CMD="magick"
else
    MAGICK_CMD="convert"
fi

echo "✓ ImageMagick found: $MAGICK_CMD"
echo ""

# Process bg-main.jpg
if [ -f "$BG_IMAGE" ]; then
    echo "Processing: bg-main.jpg"
    
    # Get current dimensions
    dimensions=$($MAGICK_CMD identify -format "%wx%h" "$BG_IMAGE")
    size=$(du -h "$BG_IMAGE" | cut -f1)
    echo "  Current: $dimensions ($size)"
    echo ""
    
    # Create backup
    if [ ! -f "$BG_IMAGE.backup" ]; then
        echo "  Creating backup..."
        cp "$BG_IMAGE" "$BG_IMAGE.backup"
    fi
    
    # Optimize: resize to max 1920px width, keep aspect ratio
    echo "  Resizing to max 1920px width..."
    $MAGICK_CMD "$BG_IMAGE.backup" \
        -resize 1920x \
        -quality 85 \
        -strip \
        "$BG_IMAGE.optimized"
    
    # Create WebP version (with max dimension check)
    echo "  Creating WebP version..."
    $MAGICK_CMD "$BG_IMAGE.optimized" \
        -resize "16000x16000>" \
        -quality 85 \
        "$IMAGE_DIR/bg-main.webp"
    
    # Get new dimensions and sizes
    new_dimensions=$($MAGICK_CMD identify -format "%wx%h" "$BG_IMAGE.optimized")
    new_size=$(du -h "$BG_IMAGE.optimized" | cut -f1)
    webp_size=$(du -h "$IMAGE_DIR/bg-main.webp" | cut -f1)
    
    echo ""
    echo "  ✅ Results:"
    echo "     Original JPG: $dimensions ($size)"
    echo "     Optimized JPG: $new_dimensions ($new_size)"
    echo "     WebP: $webp_size"
    echo ""
    
    # Replace original with optimized
    read -p "  Replace original bg-main.jpg? (y/n) " -n 1 -r
    echo ""
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        mv "$BG_IMAGE.optimized" "$BG_IMAGE"
        echo "  ✓ Replaced bg-main.jpg"
    else
        echo "  ✓ Kept original, optimized saved as bg-main.jpg.optimized"
    fi
fi

echo ""

# Process bg-main.jpeg if exists
if [ -f "$BG_JPEG" ]; then
    echo "Processing: bg-main.jpeg"
    
    dimensions=$($MAGICK_CMD identify -format "%wx%h" "$BG_JPEG")
    size=$(du -h "$BG_JPEG" | cut -f1)
    echo "  Current: $dimensions ($size)"
    echo ""
    
    # This is likely already optimized (2MB), just create WebP
    if [ ! -f "$IMAGE_DIR/bg-main-jpeg.webp" ]; then
        echo "  Creating WebP version..."
        $MAGICK_CMD "$BG_JPEG" \
            -resize "16000x16000>" \
            -quality 85 \
            "$IMAGE_DIR/bg-main-jpeg.webp"
        
        webp_size=$(du -h "$IMAGE_DIR/bg-main-jpeg.webp" | cut -f1)
        echo "  ✅ WebP created: $webp_size"
    else
        echo "  ⏭️  WebP already exists"
    fi
fi

echo ""
echo "========================================="
echo "✅ Background Optimization Complete!"
echo "========================================="
echo ""
echo "Summary:"
echo "- Original backup: bg-main.jpg.backup"
echo "- Optimized JPG: bg-main.jpg"
echo "- WebP version: bg-main.webp"
echo ""
echo "Next step: Update code to use bg-main.webp"
echo ""
