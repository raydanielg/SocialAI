import { gsap } from "gsap"
import $SplitText from "@/Plugins/Web/gsap-split-text"
export function useTitleAnimation() {
  gsap.registerPlugin($SplitText)
  const title = document.querySelector('.tp-title-anim')
  if (typeof window !== "undefined") {
    if (title) {
      let splitTitleLines = gsap.utils.toArray(".tp-title-anim")
      splitTitleLines.forEach(splitTextLine => {
        const tl = gsap.timeline({
          scrollTrigger: {
            trigger: splitTextLine,
            start: 'top 80%',
            end: 'bottom 60%',
            scrub: false,
            markers: false,
            toggleActions: 'play none none none'
          }
        })

        const itemSplitted = new $SplitText(splitTextLine, { type: "words, lines" })
        gsap.set(splitTextLine, { perspective: 300 })
        itemSplitted.split({ type: "lines" })
        tl.from(itemSplitted.lines, { duration: 1, delay: 0.3, opacity: 0, rotationX: -60, force3D: true, transformOrigin: "top center -50", stagger: 0.2 })
      })
    }
  }
}