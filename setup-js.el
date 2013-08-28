;;; setup-js.el --- Javascript setup / options

;;; Commentary:

;;; Code:

(defvar jsl-conf (file-truename "~/.emacs.d/jsl.conf"))

(flycheck-declare-checker flycheck-checker-jslint
  "jslint checker"
  :command '("jsl" (config-file "-conf" jsl-conf) "-process" source)
  :error-patterns '(("^\\(.+\\)\:\\([0-9]+\\)\: \\(SyntaxError\:.+\\)\:$" error)
                    ("^\\(.+\\)(\\([0-9]+\\)): \\(SyntaxError:.+\\)$" error)
                    ("^\\(.+\\)(\\([0-9]+\\)): \\(lint \\)?\\(warning:.+\\)$" warning)
                    ("^\\(.+\\)\:\\([0-9]+\\)\: strict \\(warning: trailing comma.+\\)\:$" warning))
  :modes 'js2-mode)

(defun after-init-js2-mode ()
  "After js2-mode init."
  (require 'flycheck)
  (require 'auto-complete)
  (add-to-list 'flycheck-checkers 'flycheck-checker-jslint)
  (auto-complete-mode t)
  (imenu-add-menubar-index)
  (hs-minor-mode t))

(setq js2-global-externs '("define"))

(add-hook 'js2-mode-hook 'after-init-js2-mode)

(provide 'setup-js)
;;; setup-js.el ends here