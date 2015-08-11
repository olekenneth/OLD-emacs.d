;;; emacsconfig --- Custom overrides of emacs config
;;; Commentary:
;;; My custom Emacs config
;;; Code:
(require 'helm-config)
(require 'helm-projectile)

(helm-mode 1)

(setq indent-tabs-mode nil)
(setq tab-width 4)

(setq-default indent-tabs-mode nil)
(setq-default tab-width 4)

(setq sgml-basic-offset 4)

(add-hook 'html-mode-hook
          (lambda ()
            (setq sgml-basic-offset 4)
            (setq indent-tabs-mode nil)))

(defun custom-open-file ()
  "Open file using projectile+Helm or ido."
  (interactive)
  (if (projectile-project-p)
      (helm-projectile)
    (helm-for-files)))

(global-set-key (kbd "C-x C-f") 'custom-open-file)

(custom-set-variables
 ;; custom-set-variables was added by Custom.
 ;; If you edit it by hand, you could mess it up, so be careful.
 ;; Your init file should contain only one such instance.
 ;; If there is more than one, they won't work right.
 '(custom-enabled-themes (quote (sanityinc-tomorrow-day)))
 '(custom-safe-themes (quote ("bb08c73af94ee74453c90422485b29e5643b73b05e8de029a6909af6a3fb3f58" "sanityinc-tomorrow-day" default)))
 '(display-time-24hr-format t)
 '(display-time-default-load-average nil)
 '(display-time-mode t)
 '(js2-basic-offset 4)
 '(newsticker-url-list (quote (("VG" "http://www.vg.no/rss/feed/forsiden?sources=vg&insiderimage=1" nil 3600 nil))))
 '(session-use-package t nil (session))
 '(timeclock-mode-line-display t nil (timeclock))
 '(timeclock-relative nil)
 '(timeclock-workday 28801))
(custom-set-faces
 ;; custom-set-faces was added by Custom.
 ;; If you edit it by hand, you could mess it up, so be careful.
 ;; Your init file should contain only one such instance.
 ;; If there is more than one, they won't work right.
 )
;;; custom.el ends here
