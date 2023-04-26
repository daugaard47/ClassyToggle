package com.daugaard47.classytoggle

import com.intellij.openapi.actionSystem.AnAction
import com.intellij.openapi.actionSystem.AnActionEvent
import com.intellij.openapi.actionSystem.CommonDataKeys
import com.intellij.openapi.application.ApplicationManager
import com.intellij.openapi.command.CommandProcessor
import com.intellij.openapi.editor.Document
import com.intellij.openapi.project.Project

class DeleteAllClassesAction : AnAction() {
    override fun actionPerformed(e: AnActionEvent) {
        val editor = e.getRequiredData(CommonDataKeys.EDITOR)
        val project = e.getRequiredData(CommonDataKeys.PROJECT)
        val document = editor.document
        ApplicationManager.getApplication().runWriteAction {
            deleteAllClasses(document, project)
        }
    }

    private fun deleteAllClasses(document: Document, project: Project) {
        val classRegex = """\s+class\s*=\s*"[^"]*"""".toRegex()
        val newText = classRegex.replace(document.text) { "" }
        CommandProcessor.getInstance().executeCommand(
            project,
            {
                document.replaceString(0, document.textLength, newText)
            },
            "Delete All Classes",
            null
        )
    }
}
