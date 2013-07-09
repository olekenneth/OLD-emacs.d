(flycheck-declare-checker flycheck-checker-jslint
  "jslint checker"
  :command '("jsl" "-process" source)
  :error-patterns '(("^\\(.+\\)\:\\([0-9]+\\)\: \\(SyntaxError\:.+\\)\:$" error)
                    ("^\\(.+\\)(\\([0-9]+\\)): \\(SyntaxError:.+\\)$" error)
                    ("^\\(.+\\)(\\([0-9]+\\)): \\(lint \\)?\\(warning:.+\\)$" warning)
                    ("^\\(.+\\)\:\\([0-9]+\\)\: strict \\(warning: trailing comma.+\\)\:$" warning))
  :modes 'js2-mode)

(defun my-after-init-js ()
  "After js init hook."
  (require 'flycheck)
  (add-to-list 'flycheck-checkers 'flycheck-checker-jslint))

(add-hook 'after-init-hook 'my-after-init-js)

(defun my-jshint ()
  "jshint enabled"
  (require 'flymake-jshint)
  (add-hook 'after-init-hook
            (lambda () (flymake-mode t)))
  ;; Turns on flymake for all files which have a flymake mode
  (add-hook 'find-file-hook 'flymake-find-file-hook)
)

(provide 'setup-js)