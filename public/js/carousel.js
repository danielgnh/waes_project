document.addEventListener('alpine:init', () => {
    Alpine.data('carousel', () => ({
        duration: 5000,
        active: 0,
        progress: 0,
        firstFrameTime: 0,
        items: [
            {
                img: 'https://cruip-tutorials.vercel.app/progress-slider/ps-image-01.png',
                desc: 'Omnichannel',
                buttonIcon: 'https://cruip-tutorials.vercel.app/progress-slider/ps-icon-01.svg',
            },
            {
                img: 'https://cruip-tutorials.vercel.app/progress-slider/ps-image-02.png',
                desc: 'Multilingual',
                buttonIcon: 'https://cruip-tutorials.vercel.app/progress-slider/ps-icon-02.svg',
            },
            {
                img: 'https://cruip-tutorials.vercel.app/progress-slider/ps-image-03.png',
                desc: 'Interpolate',
                buttonIcon: 'https://cruip-tutorials.vercel.app/progress-slider/ps-icon-03.svg',
            },
            {
                img: 'https://cruip-tutorials.vercel.app/progress-slider/ps-image-04.png',
                desc: 'Enriched',
                buttonIcon: 'https://cruip-tutorials.vercel.app/progress-slider/ps-icon-04.svg',
            },
        ],
        init() {
            this.startAnimation()
            this.$watch('active', callback => {
                cancelAnimationFrame(this.frame)
                this.startAnimation()
            })
        },
        startAnimation() {
            this.progress = 0
            this.$nextTick(() => {
                this.heightFix()
                this.firstFrameTime = performance.now()
                this.frame = requestAnimationFrame(this.animate.bind(this))
            })
        },
        animate(now) {
            let timeFraction = (now - this.firstFrameTime) / this.duration
            if (timeFraction <= 1) {
                this.progress = timeFraction * 100
                this.frame = requestAnimationFrame(this.animate.bind(this))
            } else {
                timeFraction = 1
                this.active = (this.active + 1) % this.items.length
            }
        },
        heightFix() {
            this.$nextTick(() => {
                this.$refs.items.parentElement.style.height = this.$refs.items.children[this.active + 1].clientHeight + 'px'
            })
        }
    }))
})
