;;; emacsconfig --- Custom overrides of emacs config
;;; Commentary:
(require 'helm-config)
(require 'helm-projectile)

;;; Code:
(helm-mode 1)
; (helm-autoresize-mode 1)

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
 '(session-use-package t nil (session)))
(custom-set-faces
 ;; custom-set-faces was added by Custom.
 ;; If you edit it by hand, you could mess it up, so be careful.
 ;; Your init file should contain only one such instance.
 ;; If there is more than one, they won't work right.
 )
;;; custom.el ends here
